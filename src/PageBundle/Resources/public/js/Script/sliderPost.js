// /**
//  * Created by JeanMicheMiche on 02/10/2017.
//  */
//On instencie nos galeries
$( document ).ready(function() {
    s = new slider("#galerie");

    var $carrouselPost = $('#carrousel-post'), // on cible le bloc du carrousel
        $img = $('#carrousel-post .content-post-slider'), // on cible les images contenues dans le carrousel
        indexImg = $img.length - 1, // on définit l'index du dernier élément
        i = 0, // on initialise un compteur
        $currentImg = $img.eq(i); // enfin, on cible l'image courante, qui possède l'index i (0 pour l'instant)

    // $img.css('display', 'none'); //  on cache les images
    $img.hide(); //  on cache les images
    $currentImg.show(); // on affiche seulement l'image courante
    // $currentImg.show(); // on affiche seulement l'image courante

    // $carrousel.append('<div class="controls"> <span class="prev">Precedent</span> <span class="next">Suivant</span> </div>');


    $('.next-post').click(function(){ // image suivante

        i++; // on incrémente le compteur

        if( i <= indexImg ){
            // $img.css('display', 'none'); // on cache les images
            $img.hide(); // on cache les images
            $currentImg = $img.eq(i); // on définit la nouvelle image
            // $currentImg.css('display', 'flex'); // puis on l'affiche
            $currentImg.slideUp().fadeIn(600);
        }
        else{
            i = indexImg;
        }

    });

    $('.prev-post').click(function(){ // image précédente

        i--; // on décrémente le compteur, puis on réalise la même chose que pour la fonction "suivante"

        if( i >= 0 ){
            // $img.css('display', 'none');
            $img.hide();
            $currentImg = $img.eq(i);
            // $currentImg.css('display', 'flex');
            $currentImg.slideUp().fadeIn(600);
}
        else{
            i = 0;
        }

    });

});

var slider = function(id) {
    // Définition du contexte de this pour l'appeler dans une fonction ombriqué
    var self = this;
    this.div = $(id);
    //On cherche l'élement slider dans notre première div
    this.slider =  this.div.find(".slider");
    //On récupère la longueure de la div
    this.largeurCache = this.div.width();
    //On initialise une longueure à 0
    this.largeur = 0;
    this.div.find(".slider-content").each(function(){
        self.largeur += $(this).width();
        self.largeur += parseInt($(this).css("padding-left"));
        self.largeur += parseInt($(this).css("padding-right"));
        self.largeur += parseInt($(this).css("margin-left"));
        self.largeur += parseInt($(this).css("margin-right"));
    });
    this.prec = this.div.find(".prec");
    this.suiv = this.div.find(".suiv");
    this.saut = this.largeurCache + 1;
    // this.nbEtapes = Math.ceil(this.largeur/this.saut - this.largeurCache/this.saut);
    this.nbEtapes = this.largeur/this.saut - this.largeurCache/this.saut;
    this.courant = 0;

    this.suiv.click(function(){
        if(self.courant <= self.nbEtapes) {
            self.courant++;
            self.slider.animate({
                left: -self.courant*self.saut
            }, 1000);
        }
    });

    this.prec.click(function(){
        if(self.courant > 0) {
            self.courant--;
            self.slider.animate({
                left: -self.courant*self.saut
            }, 1000);
        }
    });
};