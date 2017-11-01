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

/**
 * Class Projet
 * @ORM\Entity(repositoryClass="MainBundle\Repository\ProjetRepository")
 * @ORM\Table(name="Projet")
 * 
 * @UniqueEntity(fields="nom", message="Ce nom de projet est déjà prit !")
 */
class Projet {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Assert\Type(type="integer", message="La valeur '{{ value }}' n'est pas valide.")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true, length=64, nullable=false)
     * @Assert\NotBlank(message="Le projet doit avoir un nom !")
     * @Assert\Type(type="string", message="La valeur '{{ value }}' n'est pas valide.")
     * @Assert\Length(min=4, max=64, minMessage="Le nom du projet doit avoir {{ limit }} caractères minimum !", maxMessage="Le nom du projet ne peut pas dépasser {{ limit }} caractères !")
     */
    private $nom;

    /**
     * @ORM\Column(type="text", nullable=false)
     * @Assert\NotBlank(message="Le projet doit avoir un résumé !")
     * @Assert\Type(type="string", message="La valeur '{{ value }}' n'est pas valide.")
     * @Assert\Length(min=4, max=4096, minMessage="La description du projet doit avoir {{ limit }} caractères minimum !", maxMessage="La description du projet ne peut pas dépasser {{ limit }} caractères !")
     */
    private $resume;

    /**
     * @ORM\ManyToMany(targetEntity="Technologie", cascade={"persist"})
     * @ORM\JoinTable(name="projet_technologie",
     *      joinColumns={@ORM\JoinColumn(name="projet_id", referencedColumnName="id", nullable=false)},
     *      inverseJoinColumns={@ORM\JoinColumn(name="technologie_id", referencedColumnName="id", nullable=false)}
     *      )
     */
    private $technologies;

    /**
     * @ORM\ManyToMany(targetEntity="Langage", cascade={"persist"})
     * @ORM\JoinTable(name="projet_langage",
     *      joinColumns={@ORM\JoinColumn(name="projet_id", referencedColumnName="id", nullable=false)},
     *      inverseJoinColumns={@ORM\JoinColumn(name="langage_id", referencedColumnName="id", nullable=false)}
     *      )
     */
    private $langages;

    /**
     * @ORM\OneToMany(targetEntity="Illustration", mappedBy="projet", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $illustrations;

    /**
     * @ORM\OneToOne(targetEntity="PDF", mappedBy="projet", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $pdf;

    /**
     * @ORM\OneToOne(targetEntity="Source", mappedBy="projet", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $source;

    /**
     * Constructor
     */
    public function __construct() {
        $this->technologies = new \Doctrine\Common\Collections\ArrayCollection();
        $this->langages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->illustrations = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Projet
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
     * Set resume
     *
     * @param string $resume
     *
     * @return Projet
     */
    public function setResume($resume) {
        $this->resume = $resume;

        return $this;
    }

    /**
     * Get resume
     *
     * @return string
     */
    public function getResume() {
        return $this->resume;
    }

    /**
     * Add technology
     *
     * @param \MainBundle\Entity\Technologie $technology
     *
     * @return Projet
     */
    public function addTechnology(\MainBundle\Entity\Technologie $technology) {
        $this->technologies[] = $technology;

        return $this;
    }

    /**
     * Remove technology
     *
     * @param \MainBundle\Entity\Technologie $technology
     */
    public function removeTechnology(\MainBundle\Entity\Technologie $technology) {
        $this->technologies->removeElement($technology);
    }

    /**
     * Get technologies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTechnologies() {
        return $this->technologies;
    }

    /**
     * Add langage
     *
     * @param \MainBundle\Entity\Langage $langage
     *
     * @return Projet
     */
    public function addLangage(\MainBundle\Entity\Langage $langage) {
        $this->langages[] = $langage;

        return $this;
    }

    /**
     * Remove langage
     *
     * @param \MainBundle\Entity\Langage $langage
     */
    public function removeLangage(\MainBundle\Entity\Langage $langage) {
        $this->langages->removeElement($langage);
    }

    /**
     * Get langages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLangages() {
        return $this->langages;
    }

    /**
     * Add illustration
     *
     * @param \MainBundle\Entity\Illustration $illustration
     *
     * @return Projet
     */
    public function addIllustration(\MainBundle\Entity\Illustration $illustration) {
        $this->illustrations[] = $illustration;

        return $this;
    }

    /**
     * Remove illustration
     *
     * @param \MainBundle\Entity\Illustration $illustration
     */
    public function removeIllustration(\MainBundle\Entity\Illustration $illustration) {
        $this->illustrations->removeElement($illustration);
    }

    /**
     * Get illustrations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIllustrations() {
        return $this->illustrations;
    }

    /**
     * Set pdf
     *
     * @param \MainBundle\Entity\PDF $pdf
     *
     * @return Projet
     */
    public function setPdf(\MainBundle\Entity\PDF $pdf = null) {
        $this->pdf = $pdf;

        return $this;
    }

    /**
     * Get pdf
     *
     * @return \MainBundle\Entity\PDF
     */
    public function getPdf() {
        return $this->pdf;
    }

    /**
     * Set source
     *
     * @param \MainBundle\Entity\Source $source
     *
     * @return Projet
     */
    public function setSource(\MainBundle\Entity\Source $source = null) {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return \MainBundle\Entity\Source
     */
    public function getSource() {
        return $this->source;
    }

}
