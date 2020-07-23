<?php

namespace SolidPress\Models;

class Image {
	public $src;
	public $width;
	public $height;
	public $alt;
	public $sizes = array();

	public function __construct( string $src, int $width = 0, int $height = 0, string $alt = '', array $sizes = array() ) {
		$this->src    = $src;
		$this->width  = $width;
		$this->height = $height;
		$this->alt    = $alt;
		$this->sizes  = $sizes;

		return $this;
	}

	/**
	 * Create new Image object from post thumbnail
	 *
	 * @param integer|WP_Post $post - Post ID or WP_Post object. Default is global $post.
	 * @return Image
	 */
	public static function fromPostThumbnail( $post = 0 ):Image {
		$post          = get_post( $post );
		$id            = isset( $post->ID ) ? $post->ID : 0;
		$attachment_id = get_post_thumbnail_id( $id );

		return self::fromACF( acf_get_attachment( $attachment_id ) );
	}

	public static function fromACF( $acf_field ): Image {
		return new Image(
			$acf_field['url'],
			$acf_field['width'],
			$acf_field['height'],
			$acf_field['alt'],
			$acf_field['sizes']
		);
	}

	public function size( string $size ): Image {
		return new Image(
			$this->sizes[ $size ] ?? $this->src,
			$this->sizes[ "{$size}-width" ] ?? $this->width,
			$this->sizes[ "{$size}-height" ] ?? $this->height,
			$this->alt
		);
	}

	public function __toString() {
		return $this->src;
	}
}