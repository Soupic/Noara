// /**
//  * Created by JeanMicheMiche on 02/10/2017.
//  */
//On instencie nos galeries
$( document ).ready(function() {
    s = new slider("#galerie");
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
    this.saut = this.largeurCache;
    this.nbEtapes = Math.ceil(this.largeur/this.saut - this.largeurCache/this.saut);
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