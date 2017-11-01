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
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Langage
 * @ORM\Entity(repositoryClass="MainBundle\Repository\LangageRepository")
 * @ORM\Table(name="Langage")
 * 
 * @UniqueEntity(fields="nom", message="Ce nom de langage est déjà prit !")
 */
class Langage {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Assert\Type(type="integer", message="La valeur '{{ value }}' n'est pas valide.")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true, length=64, nullable=false)
     * @Assert\NotBlank(message="Le langage doit avoir un nom !")
     * @Assert\Type(type="string", message="La valeur '{{ value }}' n'est pas valide.")
     * @Assert\Length(min=4, max=64, minMessage="Le nom du langage doit avoir {{ limit }} caractères minimum !", maxMessage="Le nom du langage ne peut pas dépasser {{ limit }} caractères !")
     */
    private $nom;

    /**
     * @ORM\Column(type="text", nullable=false)
     * @Assert\NotBlank(message="Le langage doit avoir un résumé !")
     * @Assert\Type(type="string", message="La valeur '{{ value }}' n'est pas valide.")
     * @Assert\Length(min=4, max=4096, minMessage="La description du langage doit avoir {{ limit }} caractères minimum !", maxMessage="La description du langage ne peut pas dépasser {{ limit }} caractères !")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=256, nullable=false)
     */
    private $image;

    /**
     * @Assert\NotNull(message = "Vous devez mettre impérativement une image")
     * @Assert\File(maxSize = "1M", maxSizeMessage = "L'image est trop grosse ({{ size }} {{ suffix }}) la taille maximum est de {{ limit }} {{ suffix }}.", disallowEmptyMessage = "Une image vide n'est pas autorisée.", notFoundMessage = "L'image n'a pas pu être trouvée.", notReadableMessage = "L'image n'est pas lisable.", uploadIniSizeErrorMessage = "L'image est trop grosse la taille maximum est de {{ limit }} {{ suffix }}.", uploadFormSizeErrorMessage = "L'image est trop grosse !", uploadErrorMessage = "L'image n'a pas pu être uploadée !")
     * @Assert\Image(mimeTypes = {"image/jpeg", "image/pjpeg", "image/png", "image/bmp", "image/x-windows-bmp", "image/gif"}, mimeTypesMessage = "Seules les images du type jpg, jpeg, png, bmp ou gif sont acceptées.", maxWidth = 1920, maxHeight = 1080, sizeNotDetectedMessage = "La taille de l'image n'a pas été détectée !", maxWidthMessage = "La largeur de l'image ne peut pas dépasser {{ max_width }}px, actuellement {{ width }}px.", maxHeightMessage = "La hauteur de l'image ne peut pas dépasser {{ max_height }}px, actuellement {{ height  }}px.")
     */
    private $temporary_image;

    public function getTemporaryImage() {
        return $this->temporary_image;
    }

    public function setTemporaryImage($temporary_image) {
        $this->temporary_image = $temporary_image;
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Langage
     */
    public function setNom($nom) {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom() {
        return $this->nom;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Langage
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Langage
     */
    public function setImage($image) {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage() {
        return $this->image;
    }

}
