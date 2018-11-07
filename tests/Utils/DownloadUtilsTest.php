<?php
/**
 * Created by PhpStorm.
 * User: alexandre.tranchant
 * Date: 01/04/2018
 * Time: 13:05.
 */

namespace App\Tests\Utils;

use App\Exception\DownloadException;
use App\Utils\DownloadUtils;
use PHPUnit\Framework\TestCase;

class DownloadUtilsTest extends TestCase
{
    /**
     * Download utils to test.
     *
     * @var DownloadUtils
     */
    private $downloadUtils;

    /**
     * Setup each test.
     */
    public function setUp()
    {
        parent::setUp();

        $this->downloadUtils = new DownloadUtils();
    }

    public function testDownloadFiles()
    {
        self::markTestIncomplete();
    }

    /**
     * Test to get valid file.
     *
     * @throws \App\Exception\DownloadException
     */
    public function testGetFile()
    {
        $expected = [
            'fichier1.txt' => __DIR__ . '/../example1.htmlfichier1.txt',
            'fichier3.txt' => __DIR__ . '/../example1.htmlfichier3.txt',
            'fichier4.txt' => __DIR__ . '/../example1.htmlfichier4.txt',
        ];

        $actual = $this->downloadUtils->getFiles(__DIR__ . '/../example1.html');
        self::assertEquals($expected, $actual);
    }

    /**
     * Test to get valid empty file.
     *
     * @throws \App\Exception\DownloadException
     */
    public function testGetEmptyFile()
    {
        $expected = [];

        $actual = $this->downloadUtils->getFiles(__DIR__ . '/../empty.html');
        self::assertEquals($expected, $actual);
    }

    /**
     * Test to get non-valid file.
     *
     * @throws \App\Exception\DownloadException
     */
    public function testGetNonValidFile()
    {
        self::expectException(DownloadException::class);
        self::expectExceptionMessage('Impossible de lire le contenu du répertoire d’archive de la caméra.');

        $this->downloadUtils->getFiles('non-valide.txt');
    }

    /**
     * Test immatriculation simplification.
     *
     */
    public function testSimplify()
    {
        $tests = [
            "-" => "",
            "AA555CC" => "AA555CC",
            "SS555BB" => "5555588",
            "COQ" => "C00",
            "1234567" => "1234567",
            "OISBOISB" => "01580158"
        ];

        foreach ($tests as $actual => $expected) {
            self::assertEquals($expected, $this->downloadUtils->simplify($actual));
        }
    }
}
