<?php

namespace Wenprise\SessionManager;

use Wenprise\SessionManager\Handlers\CacheHandler;
use Wenprise\SessionManager\Handlers\DatabaseHandler;

class Init {

	public function __construct($force_db_handler = false) {
		if ( ! isset( $_SESSION ) ) {
			// Queue up the session stack.
			$wp_session_handler = Manager::initialize();

			// 如果使用了对象缓存，设置对象缓存为 Handler
			if ( wp_using_ext_object_cache() && ! $force_db_handler ) {
				$wp_session_handler->addHandler( new CacheHandler() );
			} else {
				$wp_session_handler->addHandler( new DatabaseHandler() );
			}

			/**
			 * The database handler can automatically clean up sessions as it goes. By default,
			 * we'll run the cleanup routine every hour to catch any stale sessions that PHP's
			 * garbage collector happens to miss. This timeout can be filtered to increase or
			 * decrease the frequency of the manual purge.
			 *
			 * @param string $timeout Interval with which to purge stale sessions
			 */
			$timeout = apply_filters( 'wenprise_session_gc_interval', 'hourly' );

			if ( ! wp_next_scheduled( 'wenprise_session_database_gc' ) ) {
				wp_schedule_event( time(), $timeout, 'wenprise_session_database_gc' );
			}

			add_action( 'wenprise_session_database_gc', [ 'EAMann\WPSession\DatabaseHandler', 'directClean' ] );

			$_SESSION[ 'wenprise_session_manager' ] = 'active';
		}

		// If we're not in a cron, start the session
		if ( ! defined( 'DOING_CRON' ) || false === DOING_CRON ) {
			if ( session_status() !== PHP_SESSION_ACTIVE ) {
				session_start();
			}
		}

	}

}