<?php

/*
 * @license https://creativecommons.org/licenses/by-nc/3.0/fr/
 * 
 * Creative Commons Attribution Pas d'Utilisation Commerciale 3.0 France
 * 
 * L'ŒUVRE (TELLE QUE DEFINIE CI-DESSOUS) EST MISE A DISPOSITION SELON LES TERMES DE CETTE LICENCE PUBLIQUE CREATIVE COMMONS (CI-APRES DENOMMEE « LPCC » OU « LICENCE »). 
 * L'ŒUVRE EST PROTEGEE PAR LE DROIT DE LA PROPRIETE LITTERAIRE ET ARTISTIQUE OU TOUTE AUTRE LOI APPLICABLE. 
 * TOUTE UTILISATION DE L'ŒUVRE AUTRE QUE CELLE AUTORISEE PAR CETTE LICENCE EST RÉSERVÉE.
 * L’EXERCICE DE TOUT DROIT SUR L’ŒUVRE MISE A DISPOSITION EMPORTE ACCEPTATION DES TERMES DE LA LICENCE. 
 * EN RAISON DU CARACTERE CONTRACTUEL DE LA LICENCE, L’OFFRANT ACCORDE A L’ACCEPTANT LES DROITS CONTENUS DANS CETTE LICENCE EN CONTREPARTIE DE SON ACCEPTATION.
 * 
 * PARTAGER — copier, distribuer et communiquer le matériel par tous moyens et sous tous formats.
 * ADAPTER — remixer, transformer et créer à partir du matériel.
 * ATTRIBUTION — Vous devez créditer l'Œuvre, intégrer un lien vers la licence et indiquer si des modifications ont été effectuées à l'Oeuvre. 
 * Vous devez indiquer ces informations par tous les moyens raisonnables, sans toutefois suggérer que l'Offrant vous soutient ou soutient la façon dont vous avez utilisé son Oeuvre. 
 * PAS D'UTILISATION COMMERCIALE — Vous n'êtes pas autorisé à faire un usage commercial de cette Oeuvre, tout ou partie du matériel la composant. 
 * 
 * Vous n'êtes pas dans l'obligation de respecter la licence pour les éléments ou matériel appartenant au domaine public ou dans le cas où l'utilisation que vous souhaitez faire est couverte par une exception.
 * Aucune garantie n'est donnée. Il se peut que la licence ne vous donne pas toutes les permissions nécessaires pour votre utilisation. 
 * Certains droits comme les droits moraux, le droit des données personnelles et le droit à l'image sont susceptibles de limiter votre utilisation.
 * Si vous n'avez pas la licence complète prenez référence ici <https://creativecommons.org/licenses/by-nc/3.0/fr/legalcode>.
 */

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Source
 * @ORM\Entity(repositoryClass="MainBundle\Repository\SourceRepository")
 * @ORM\Table(name="Source")
 * 
 */
class Source {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Assert\Type(type="integer", message="La valeur '{{ value }}' n'est pas valide.")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=256, nullable=true)
     */
    private $path;

    /**
     * @Assert\File(mimeTypes={"application/zip", "application/gzip", "application/x-rar-compressed"},  mimeTypesMessage = "Veuiller insérer un code source valide", maxSize = "50M", maxSizeMessage = "Le code source est trop gros ({{ size }} {{ suffix }}) la taille maximum est de {{ limit }} {{ suffix }}.", disallowEmptyMessage = "Un fichier vide n'est pas autorisée.", notFoundMessage = "Le fichier n'a pas pu être trouvée.", notReadableMessage = "Le fichier n'est pas lisable.", uploadIniSizeErrorMessage = "Le fichier est trop gros la taille maximum est de {{ limit }} {{ suffix }}.", uploadFormSizeErrorMessage = "Le fichier est trop gros !", uploadErrorMessage = "Le fichier n'a pas pu être uploadée !")
     */
    private $temporary_path;

    /**
     * @ORM\OneToOne(targetEntity="Projet", inversedBy="source")
     * @ORM\JoinColumn(name="projet_id", referencedColumnName="id", nullable=false)
     * @Assert\NotNull(message="Un code source doit avoir un projet !")
     */
    private $projet;

    public function getTemporaryPath() {
        return $this->temporary_path;
    }

    public function setTemporaryPath($temporary_path) {
        $this->temporary_path = $temporary_path;
        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Source
     */
    public function setPath($path) {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * Set projet
     *
     * @param \MainBundle\Entity\Projet $projet
     *
     * @return Source
     */
    public function setProjet(\MainBundle\Entity\Projet $projet) {
        $this->projet = $projet;

        return $this;
    }

    /**
     * Get projet
     *
     * @return \MainBundle\Entity\Projet
     */
    public function getProjet() {
        return $this->projet;
    }

}
