<?php

class ImageMark {

	private static function createOverlay($text, $font, $width, $height) {
		/* Create Imagick objects */
		$imagick = new Imagick();
		$draw = new ImagickDraw();
		$color = new ImagickPixel('#000000');
		$transparent = new ImagickPixel('none');
		/* Font properties */
		$draw->setFont('fonts/'.$font);
		$draw->setFillColor($color);
		$draw->setStrokeAntialias(true);
		$draw->setTextAntialias(true);
		$draw->setTextEncoding('UTF-8');
		/* Try to set font size */
		for($i = 6; $i > 0; $i--) {
			$draw->setFontSize(12 * $i);
			/* Get font metrics */
			$metrics = $imagick->queryFontMetrics($draw, $text);
			if($metrics['textWidth'] <= $width / 2 && $metrics['textHeight'] <= $height / 2) break;
		}
		if($i === 0) {
			throw new RuntimeException('Image too small');
		}
		/* Create text */
		$draw->annotation(0, $metrics['ascender'], $text);
		/* Create image */
		$imagick->newImage($width, $height, $transparent);
		$imagick->setImageFormat('png');
		$imagick->drawImage($draw);
		/* rotate image copy */
		$imagick2 = clone $imagick;
		$imagick2->rotateImage($transparent, 180);
		/* composite image */
		$imagick->compositeImage($imagick2, Imagick::COMPOSITE_OVER, 0, 0);
		return $imagick;
	}

	public static function write($filepath, $text, $font) {
		$imagick = new Imagick(realpath($filepath));
		$size = $imagick->getImageGeometry();

		$imagick->forwardFourierTransformImage(true);
		$imagick->setIteratorIndex(0);
		$magnitude = $imagick->getImage();
		$imagick->setIteratorIndex(1);
		$imagickPhase = $imagick->getImage();

		$mask = self::createOverlay($text, $font, $size['width'], $size['height']);
		$imagickPhase->compositeImage($mask, Imagick::COMPOSITE_MULTIPLY, 0, 0);

		$magnitude->inverseFourierTransformImage($imagickPhase, true);
		return $magnitude;
	}

	public static function read($imagick) {
		$imagick->forwardFourierTransformImage(true);
		$imagick->setIteratorIndex(1);
		return $imagick->getImage();
	}

	public static function output($imagick) {
		$imagick->setimageformat('png');
		header('Content-Type: image/png');
		echo $imagick->getImageBlob();
	}

}
