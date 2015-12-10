<?php 

$pRate = 160;

$imgPath = "im.jpg"; //origin file
$nImgPath = "nIm.jpg"; //destination file

$exp = explode('.', $imgPath);
$ext = $exp[count($exp)-1];

switch(strtolower($ext)){
	case 'jpg':
		$image = imagecreatefromjpeg($imgPath);
		break;

	case 'gif':
		$image = imagecreatefromgif($imgPath);
		break;

	case 'png':
		$image = imagecreatefrompng($imgPath);
		break;
}

$imagePb = $image;
$imgFrame = imagecreatetruecolor($pRate, $pRate);
imagecopyresampled($imgFrame, $imagePb, 0, 0, 0, 0, $pRate, $pRate, imagesx($imagePb), imagesy($imagePb));

imagecopymergegray($imgFrame, $image, 0, 0, 0, 0, imagesx($image), imagesy($image), 0);
$imageFinal = $imgFrame;

imagejpeg($imageFinal, $nImgPath, 100);

for($line=0; $line<$pRate; $line++){
	for($column=0; $column<$pRate; $column++){
		$color =  imagecolorat($imageFinal, $line, $column);
		$rgb = imagecolorsforindex($imageFinal, $color);
		$gray = ($rgb['red']+$rgb['green']+$rgb['blue'])/3;
		$indexes[$line][$column] = ($gray*100)/255;
		
		$blocks .= "<div style='background: rgb($gray, $gray, $gray)';></div>";
	}
}

//print_r($indexes);
?>

<html>
	<header>
		<title>ImgDecompiler</title>
		<style>
			#imgBlocks{
				position: relative;
				display: block;
				width: <?=($pRate*10)?>px;
				height: <?=($pRate*10)?>px;
				font-size: 0;
			}
			
			#imgBlocks>div{
				width: 10px;
				height: 10px;
				position: relative;
				display: inline-block;
				border-radius: 50px;
			}
			
		</style>
		
	</header>
<body>
	<img src="im.jpg?c=2452" width='400px' />
	<img src="nIm.jpg?c=2346" width='' />
	
	<div id='imgBlocks'>
		<?=$blocks?>
	</div>
</body>
</html>
