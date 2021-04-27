<?php


namespace TestWork;


class Bootstrap {

	private array $config = [];

	private Model $model;
	private View $view;

	/**
	 * Bootstrap constructor.
	 */
	public function __construct() {
		$this->config = $this->getConfig();
		if ( ! empty( $this->config ) ) {
			$this->model = new Model( $this->config );
			$this->view  = new View( $this->config );
		}
	}

	public function run() {
		if ( is_object( $this->model ) ) {
			$this->model->save( $this->getUserInfo() );
		}
		if ( is_object( $this->view ) ) {
			$this->view->show();
		}
	}

	protected function getUserInfo(): array {
		return [
			'ip_address' => ( ! empty( $_SERVER['HTTP_X_REAL_IP'] ) ) ? $_SERVER['HTTP_X_REAL_IP'] : $_SERVER['HTTP_X_FORWARDED_FOR'],
			'user_agent' => $_SERVER['HTTP_USER_AGENT'],
			'view_date'  => date( 'Y-m-d__h:i:s' ),
			'page_url'   => parse_url($_SERVER["HTTP_REFERER"])['path'],
		];
	}

	private function getConfig(): array {
		$config               = include 'settings/config.php';
		$config ['root_path'] = dirname( __FILE__, 2 );

		return $config;
	}
}