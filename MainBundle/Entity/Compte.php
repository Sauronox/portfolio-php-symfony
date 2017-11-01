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
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Class Compte
 * @ORM\Entity(repositoryClass="MainBundle\Repository\CompteRepository")
 * @ORM\Table(name="Compte")
 * 
 * @UniqueEntity(fields="username", message="Cette adresse email est déjà pris !")
 * @UniqueEntity(fields="pseudonyme", message="Ce pseudonyme est déjà pris !")
 */
class Compte implements AdvancedUserInterface, \Serializable {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Assert\Type(type="integer", message="La valeur '{{ value }}' n'est pas valide.")
     */
    private $id;

    /**
     * @ORM\Column(type="array", nullable=false)
     * @Assert\NotBlank(message="Un élève doit avoir au moins un rôle !")
     * @Assert\Type(type="array", message="La valeur '{{ value }}' n'est pas valide.")
     */
    private $roles;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     * @Assert\Choice(choices = {0, 1, true, false}, message = "Vous n'avez pas choisis si le compte est banni.")
     */
    private $isActive = true;

    /**
     * @ORM\Column(type="string", unique=true, length=254, nullable=false)
     * @Assert\NotBlank(message="Vous devez avoir une adresse email pour se connecter !")
     * @Assert\Email(message = "L'adresse mail '{{ value }}' n'est pas valide.", checkMX = true, checkHost = true)
     * @Assert\Type(type="string", message="La valeur '{{ value }}' n'est pas valide.")
     * @Assert\Length(min=4, max=254, minMessage="Le mail doit avoir des caractères !", maxMessage="Le mail ne peut pas dépasser {{ limit }} caractères !")
     */
    private $username;
    
    /**
     * @ORM\Column(type="string", unique=true, length=64, nullable=false)
     * @Assert\NotBlank(message="Vous devez avoir un pseudonyme !")
     * @Assert\Type(type="string", message="La valeur '{{ value }}' n'est pas valide.")
     * @Assert\Length(min=4, max=64, minMessage="Le pseudonyme doit avoir {{ limit }} caractères minimum !", maxMessage="Le pseudonyme ne peut pas dépasser {{ limit }} caractères !")
     */
    private $pseudonyme;

    /**
     * @ORM\Column(type="string", length=256, nullable=true)
     * @Assert\File(maxSize = "500k", maxSizeMessage = "L'image est trop grosse ({{ size }} {{ suffix }}) la taille maximum est de {{ limit }} {{ suffix }}.", disallowEmptyMessage = "Une image vide n'est pas autorisée.", notFoundMessage = "L'image n'a pas pu être trouvée.", notReadableMessage = "L'image n'est pas lisable.", uploadIniSizeErrorMessage = "L'image est trop grosse la taille maximum est de {{ limit }} {{ suffix }}.", uploadFormSizeErrorMessage = "L'image est trop grosse !", uploadErrorMessage = "L'image n'a pas pu être uploadée !")
     * @Assert\Image(mimeTypes = {"image/jpeg", "image/pjpeg", "image/png", "image/bmp", "image/x-windows-bmp", "image/gif"}, mimeTypesMessage = "Seules les images du type jpg, jpeg, png, bmp ou gif sont acceptées.", maxWidth = 500, maxHeight = 500, sizeNotDetectedMessage = "La taille de l'image n'a pas été détectée !", maxWidthMessage = "La largeur de l'image ne peut pas dépasser {{ max_width }}px, actuellement {{ width }}px.", maxHeightMessage = "La hauteur de l'image ne peut pas dépasser {{ max_height }}px, actuellement {{ height  }}px.")
     */
    private $avatar;
    
    /**
     * @ORM\Column(type="string", length=256, nullable=true)
     * @Assert\File(maxSize = "1M", maxSizeMessage = "L'image est trop grosse ({{ size }} {{ suffix }}) la taille maximum est de {{ limit }} {{ suffix }}.", disallowEmptyMessage = "Une image vide n'est pas autorisée.", notFoundMessage = "L'image n'a pas pu être trouvée.", notReadableMessage = "L'image n'est pas lisable.", uploadIniSizeErrorMessage = "L'image est trop grosse la taille maximum est de {{ limit }} {{ suffix }}.", uploadFormSizeErrorMessage = "L'image est trop grosse !", uploadErrorMessage = "L'image n'a pas pu être uploadée !")
     * @Assert\Image(mimeTypes = {"image/jpeg", "image/pjpeg", "image/png", "image/bmp", "image/x-windows-bmp", "image/gif"}, mimeTypesMessage = "Seules les images du type jpg, jpeg, png, bmp ou gif sont acceptées.", maxWidth = 1920, maxHeight = 1080, sizeNotDetectedMessage = "La taille de l'image n'a pas été détectée !", maxWidthMessage = "La largeur de l'image ne peut pas dépasser {{ max_width }}px, actuellement {{ width }}px.", maxHeightMessage = "La hauteur de l'image ne peut pas dépasser {{ max_height }}px, actuellement {{ height  }}px.")
     */
    private $image;

    protected $oldPassword;

    /**
     * Le $plainPassword est le $password non encrypté, nourrit avec un form avant de se faire encrypter et placé dans $password.
     * 
     * @Assert\Type(type="string", message="La valeur '{{ value }}' n'est pas valide.")
     * @Assert\Length(min=4, max=64, minMessage="Le mot de passe doit avoir {{ limit }} caractères minimum !", maxMessage="Le mot de passe ne peut pas dépasser {{ limit }} caractères !")
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=64, nullable=false, name="`password`")
     * @Assert\Type(type="string", message="La valeur '{{ value }}' n'est pas valide.")
     * @Assert\Length(min=4, max=64, minMessage="Le mot de passe doit avoir {{ limit }} caractères minimum !", maxMessage="Le mot de passe ne peut pas dépasser {{ limit }} caractères !")
     */
    private $password;
    

    public function __construct() {
        $this->roles = array('ROLE_ADMIN');
        $this->isActive = true;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getOldPassword() {
        return $this->oldPassword;
    }

    public function setOldPassword($oldPassword) {
        $this->oldPassword = $oldPassword;
        return $this;
    }

    public function getPlainPassword() {
        return $this->plainPassword;
    }

    public function setPlainPassword($password) {
        $this->plainPassword = $password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getSalt() {
        return null;
    }

    public function eraseCredentials() {
        
    }

    public function getRoles() {
        return $this->roles;
    }

    public function getPassword() {
        return $this->password;
    }

    public function isAccountNonExpired() {
        return true;
    }

    public function isAccountNonLocked() {
        return true;
    }

    public function isCredentialsNonExpired() {
        return true;
    }

    public function isEnabled() {
        return $this->isActive;
    }

    public function serialize() {
        return serialize(array($this->id, $this->username, $this->password));
    }

    public function unserialize($serialized) {
        list ($this->id, $this->username, $this->password) = unserialize($serialized);
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return Compte
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Compte
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set pseudonyme
     *
     * @param string $pseudonyme
     *
     * @return Compte
     */
    public function setPseudonyme($pseudonyme)
    {
        $this->pseudonyme = $pseudonyme;

        return $this;
    }

    /**
     * Get pseudonyme
     *
     * @return string
     */
    public function getPseudonyme()
    {
        return $this->pseudonyme;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return Compte
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Compte
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
}
