<?php
/*
* File: SimpleImage.php
* Author: Simon Jarvis
* Copyright: 2006 Simon Jarvis
* Date: 08/11/06
* Link: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php
* 
* This program is free software; you can redistribute it and/or 
* modify it under the terms of the GNU General Public License 
* as published by the Free Software Foundation; either version 2 
* of the License, or (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful, 
* but WITHOUT ANY WARRANTY; without even the implied warranty of 
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the 
* GNU General Public License for more details: 
* http://www.gnu.org/licenses/gpl.html
*
*/
//Set Maximum Memory limit
ini_set('memory_limit', '120M');
class simpleImage {
   
   public $image;
   public $image_type;
   /* Load a image file to memory */
   function load($filename) {
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
         $this->image = imagecreatefrompng($filename);
      }
   }
   /* Save the file into a directory */
   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=0644) {
      if( $this->image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
         imagegif($this->image,$filename);         
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
         imagepng($this->image,$filename);
      }   
      if( $permissions != null) {
         chmod($filename,$permissions);
      }
   }
   /* Write the image to the screen */
   function output($image_type=IMAGETYPE_JPEG) {
      if( $this->image_type == IMAGETYPE_JPEG ) {
		  header("Content-type:  image/jpg");
          imagejpeg($this->image);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
		  header("Content-type:  image/gif");
          imagegif($this->image);         
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
		  header("Content-type:  image/png");
          imagepng($this->image);
      }
   }
   /* Get the width of the image */
   function getWidth() {
      return imagesx($this->image);
   }
   /* Get the Height of the image */
   function getHeight() {
      return imagesy($this->image);
   }
   /* Resize the image to given Height (Width can vary)*/
   function resizeToHeight($height) {
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
   /* Resize the image to given Width (Height can vary)*/
   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }
   /* Scale the image in percentage */
   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100; 
      $this->resize($width,$height);
   }
   /* Resize the image to given height and width */
   function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;   
   }
   /* Resize the image to given max width or max height depends on dimensions of the image */
   function resizeToFit($maxWidth, $maxHeight)
   {
		// original dimensions
		$w = $this->getWidth();
		$h = $this->getHeight();
	
		// Longest and shortest dimension
		$longestDimension = ($w > $h)? $w : $h;
		$shortestDimension = ($w < $h)? $w : $h;
	
		// propotionality
		$factor = ((float) $longestDimension) / $shortestDimension;
	
		// default width is greater than height
		$newWidth = $maxWidth;
		$newHeight = $maxWidth / $factor;
	
		// if height greater than width recalculate
		if ($w < $h )
		{
			$newWidth = $maxHeight / $factor;
			$newHeight = $maxHeight;
		}
		// Resize the image
		$this->resize($newWidth,$newHeight);
   }
   /* Return the Image for further use in any other classes */
   function getImage()
   {
   		return ($this->image);
   }
}
?>
