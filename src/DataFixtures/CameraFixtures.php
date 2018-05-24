<?php
/**
 * Created by PhpStorm.
 * User: alexandre.tranchant
 * Date: 30/03/2018
 * Time: 21:35.
 */

namespace App\DataFixtures;

use App\Entity\Camera;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CameraFixtures extends Fixture
{
    /*
     * Nombre de caméras après installation automatique.
     */
    const QUANTITE = 17;

    /*
     * Nombre de caméras actives après installation automatique.
     */
    const ACTIVES = 1;

    /*
     * Nombre de caméras inactives après installation automatique.
     */
    const INACTIVES = self::QUANTITE - self::ACTIVES;

    /**
     * Chargement des caméras.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        //Création de chacune des caméras

        $camera = new Camera();
        $camera->setActive(false);
        $camera->setCode('A630Inter');
        $camera->setIpCamera('192.168.0.1');
        $camera->setIpRouter('192.168.0.6');
        $camera->setMasque(29);
        $camera->setName('A630 – PMV Mérignac – Sens Intérieur');
        $camera->setSerialNumber('');
        $camera->setType('reco');
        $camera->setLatitude(44.8238056);
        $camera->setLongitude(-0.67445);
        $manager->persist($camera);

        $camera = new Camera();
        $camera->setActive(false);
        $camera->setCode('A630Exter');
        $camera->setIpCamera('192.168.0.9');
        $camera->setIpRouter('192.168.0.14');
        $camera->setMasque(29);
        $camera->setName('A630 – PMV Mérignac – Sens Extérieur');
        $camera->setSerialNumber('');
        $camera->setType('reco');
        $camera->setLatitude(44.8238056);
        $camera->setLongitude(-0.6747);
        $manager->persist($camera);

        $camera = new Camera();
        $camera->setActive(false);
        $camera->setCode('RN230Inter');
        $camera->setIpCamera('192.168.0.17');
        $camera->setIpRouter('192.168.0.22');
        $camera->setMasque(29);
        $camera->setName('RN230 – PMV Floirac – Sens Intérieur');
        $camera->setSerialNumber('');
        $camera->setType('reco');
        $camera->setLatitude(44.8164444);
        $camera->setLongitude(-0.52092);
        $manager->persist($camera);

        $camera = new Camera();
        $camera->setActive(false);
        $camera->setCode('RN230Exter');
        $camera->setIpCamera('192.168.0.25');
        $camera->setIpRouter('192.168.0.30');
        $camera->setMasque(29);
        $camera->setName('RN230 – PMV Floirac – Sens Extérieur');
        $camera->setSerialNumber('');
        $camera->setType('reco');
        $camera->setLatitude(44.8164444);
        $camera->setLongitude(-0.52075);
        $manager->persist($camera);

        $camera = new Camera();
        $camera->setActive(false);
        $camera->setCode('RN10BdxPar');
        $camera->setIpCamera('192.168.0.33');
        $camera->setIpRouter('192.168.0.38');
        $camera->setMasque(29);
        $camera->setName('RN10 - Ecotaxe Laruscade – Sens Bordeaux Paris');
        $camera->setSerialNumber('');
        $camera->setType('reco');
        $camera->setLatitude(45.1578333);
        $camera->setLongitude(-0.3515555555555555);
        $manager->persist($camera);

        $camera = new Camera();
        $camera->setActive(false);
        $camera->setCode('RN10ParBdx');
        $camera->setIpCamera('192.168.0.41');
        $camera->setIpRouter('192.168.0.46');
        $camera->setMasque(29);
        $camera->setName('RN10 - Ecotaxe Laruscade – Sens Paris Bordeaux');
        $camera->setSerialNumber('');
        $camera->setType('reco');
        $camera->setLatitude(45.15787);
        $camera->setLongitude(-0.3517);
        $manager->persist($camera);

        $camera = new Camera();
        $camera->setActive(false);
        $camera->setCode('RN89BdxLyon');
        $camera->setIpCamera('192.168.0.49');
        $camera->setIpRouter('192.168.0.54');
        $camera->setMasque(29);
        $camera->setName('RN89 – Ecotaxe Vayres – Sens Bordeaux Lyon');
        $camera->setSerialNumber('');
        $camera->setType('reco');
        $camera->setLatitude(44.8836389);
        $camera->setLongitude(-0.33025);
        $manager->persist($camera);

        $camera = new Camera();
        $camera->setActive(false);
        $camera->setCode('RN89LyonBdx');
        $camera->setIpCamera('192.168.0.57');
        $camera->setIpRouter('192.168.0.62');
        $camera->setMasque(29);
        $camera->setName('RN89 – Ecotaxe Vayres – Sens Lyon Bordeaux');
        $camera->setSerialNumber('');
        $camera->setType('reco');
        $camera->setLatitude(44.88375);
        $camera->setLongitude(-0.33025);
        $manager->persist($camera);

        $camera = new Camera();
        $camera->setActive(false);
        $camera->setCode('A62BdxToul');
        $camera->setIpCamera('192.168.0.65');
        $camera->setIpRouter('192.168.0.70');
        $camera->setMasque(29);
        $camera->setName('A62 – Ecotaxe St Medard – Sens Bordeaux Toulouse');
        $camera->setSerialNumber('');
        $camera->setType('reco');
        $camera->setLatitude(44.7053187468417);
        $camera->setLongitude(-0.507841010252605);
        $manager->persist($camera);

        $camera = new Camera();
        $camera->setActive(false);
        $camera->setCode('A62ToulBdx');
        $camera->setIpCamera('192.168.0.73');
        $camera->setIpRouter('192.168.0.78');
        $camera->setMasque(29);
        $camera->setName('A62 – Ecotaxe St Medard – Sens Toulouse Bordeaux');
        $camera->setSerialNumber('');
        $camera->setType('reco');
        $camera->setLatitude(44.7053889);
        $camera->setLongitude(-0.5076666666666667);
        $manager->persist($camera);

        $camera = new Camera();
        $camera->setActive(false);
        $camera->setCode('A10BdxPar');
        $camera->setIpCamera('192.168.0.81');
        $camera->setIpRouter('192.168.0.86');
        $camera->setMasque(29);
        $camera->setName('A10 – PMT Reignac – Sens Bordeaux Paris');
        $camera->setSerialNumber('');
        $camera->setType('reco');
        $camera->setLatitude(45.2268889);
        $camera->setLongitude(-0.5183055555555556);
        $manager->persist($camera);

        $camera = new Camera();
        $camera->setActive(false);
        $camera->setCode('A10ParBdx');
        $camera->setIpCamera('192.168.0.89');
        $camera->setIpRouter('192.168.0.94');
        $camera->setMasque(29);
        $camera->setName('A10 – PMT Reignac – Sens Paris Bordeaux');
        $camera->setSerialNumber('');
        $camera->setType('reco');
        $camera->setLatitude(45.0958889);
        $camera->setLongitude(-0.4753888888888889);
        $manager->persist($camera);

        $camera = new Camera();
        $camera->setActive(false);
        $camera->setCode('A63BdxBay1');
        $camera->setIpCamera('192.168.0.97');
        $camera->setIpRouter('192.168.0.102');
        $camera->setMasque(29);
        $camera->setName('A63 – Péage Saugnacq – Sens Bordeaux Bayonne - 1');
        $camera->setSerialNumber('');
        $camera->setType('reco');
        $camera->setLatitude(44.3476111);
        $camera->setLongitude(-0.860111111111111);
        $manager->persist($camera);

        $camera = new Camera();
        $camera->setActive(false);
        $camera->setCode('A63BdxBay2');
        $camera->setIpCamera('192.168.0.105');
        $camera->setIpRouter('192.168.0.110');
        $camera->setMasque(29);
        $camera->setName('A63 – Péage Saugnacq – Sens Bordeaux Bayonne - 2');
        $camera->setSerialNumber('');
        $camera->setType('reco');
        $camera->setLatitude(44.3465556);
        $camera->setLongitude(-0.8601666666666666);
        $manager->persist($camera);

        $camera = new Camera();
        $camera->setActive(false);
        $camera->setCode('A63BayBdx1');
        $camera->setIpCamera('192.168.0.113');
        $camera->setIpRouter('192.168.0.118');
        $camera->setMasque(29);
        $camera->setName('A63 – Péage Saugnacq – Sens Bayonne Bordeaux - 1');
        $camera->setSerialNumber('');
        $camera->setType('reco');
        $camera->setLatitude(44.34762);
        $camera->setLongitude(-0.860111);
        $manager->persist($camera);

        $camera = new Camera();
        $camera->setActive(false);
        $camera->setCode('A63BayBdx2');
        $camera->setIpCamera('192.168.0.121');
        $camera->setIpRouter('192.168.0.126');
        $camera->setMasque(29);
        $camera->setName('A63 – Péage Saugnacq – Sens Bayonne Bordeaux - 1');
        $camera->setSerialNumber('');
        $camera->setType('reco');
        $camera->setLatitude(44.3465556);
        $camera->setLongitude(-0.86017);
        $manager->persist($camera);

        $camera = new Camera();
        $camera->setActive(true);
        $camera->setCode('TEST');
        $camera->setIpCamera('172.22.42.122');
        $camera->setIpRouter('172.22.32.3');
        $camera->setMasque(20);
        $camera->setName('Parking CEREMA');
        $camera->setSerialNumber('');
        $camera->setType('reco');
        $camera->setLatitude(44.884626);
        $camera->setLongitude(-0.742790);
        $manager->persist($camera);

        $manager->flush();
    }
}
