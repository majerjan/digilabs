<?php
declare(strict_types=1);

namespace App\Helpers;

use App\Dto\DataItemDto;
use App\Resource\IDataResource;
use Nette\Utils\Strings;

class GifCreatorHelper {

    private const FONT = 5;
    private const PADDING = 50;
    private const LINE_HEIGHT = 15;
    private const FONT_COLOR = 0xFFFFFF;
    private const TEXT_LENGTH = 60;

    public function createGifFromJpeg(IDataResource $resource, DataItemDto $item): bool {
        $image = imagecreatefromjpeg($resource->getImagePath());
        list($width, $height) = getimagesize($resource->getImagePath());
        list($upLines, $downLines) = $this->splitToHalfAndExplode($item->getJoke());
        $x = $y = self::PADDING;

        $this->print($image, $x, $y, $upLines);
        $this->print($image, $x, $this->getYDownPosition($height, count($downLines)), $downLines);

        $response = imagegif($image, $this->createGifFilePath($item->getId()));

        imagedestroy($image);

        return $response;
    }

    public function createGifFileName($id): string {
        return sprintf('%d%s', $id, '.gif');
    }

    public function createGifFilePath(int $id): string {
        return PathHelper::concatPath([PathHelper::getTemp(), $this->createGifFileName($id)]);
    }

    public function print(
        $image,
        int $x,
        int $y,
        array $lines
    ): void {
        foreach ($lines as $line) {
            imagestring($image, self::FONT, $x, $y, $line, self::FONT_COLOR);
            $y += self::LINE_HEIGHT;
        }
    }

    /**
     * @return array<int, array<string>>
     */
    public function splitToHalfAndExplode(string $text): array {
        $roundedHalf = (int) floor(strlen($text) / 2);
        $half = strrpos(substr($text, 0, $roundedHalf), ' ') + 1;

        $upLines = explode('\n', wordwrap(substr($text, 0, $half), self::TEXT_LENGTH,'\n'));
        $downLines = explode('\n', wordwrap(substr($text, $half), self::TEXT_LENGTH,'\n'));

        return [$upLines, $downLines];
    }

    public function getYDownPosition(
        int $height,
        $linesCount
    ): int {
        return $height - (self::PADDING + $linesCount * self::LINE_HEIGHT);
    }
}