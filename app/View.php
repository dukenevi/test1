<?php


namespace TestWork;


class View {

	private string $image_file = "";
	private array $config;

	/**
	 * View constructor.
	 */
	public function __construct( array $config ) {
		$this->config = $config;

		$this->image_file = $this->config['root_path'] . $this->config['image'];
	}

	/**
	 * Show image in src
	 */
	public function show() {
		if ( file_exists( $this->image_file ) ) {
			$image_info = getimagesize( $this->image_file );
			header( "Content-Type: {$image_info['mime']}" );
			header( 'Content-Length: ' . filesize( $this->image_file ) );
			readfile( $this->image_file );
		}
//		die;
	}
}