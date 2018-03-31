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
        $manager->persist($camera);

        $manager->flush();
    }
}
