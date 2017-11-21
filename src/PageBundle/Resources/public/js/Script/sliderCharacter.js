$( document ).ready(function() {
    var $carrouselCharacter = $('#carrousel-character'), // on cible le bloc du carrousel
        $img = $('#carrousel-character .content-character-slider'), // on cible les images contenues dans le carrousel
        indexImg = $img.length - 1, // on définit l'index du dernier élément
        i = 0, // on initialise un compteur
        $currentImg = $img.eq(i); // enfin, on cible l'image courante, qui possède l'index i (0 pour l'instant)

    // $img.css('display', 'none'); //  on cache les images
    $img.hide(); //  on cache les images
    $currentImg.show(); // on affiche seulement l'image courante
    // $currentImg.show(); // on affiche seulement l'image courante

    // $carrousel.append('<div class="controls"> <span class="prev">Precedent</span> <span class="next">Suivant</span> </div>');


    $('.next-char').click(function(){ // image suivante

        i++; // on incrémente le compteur

        if( i <= indexImg ){
            // $img.css('display', 'none'); // on cache les images
            $img.hide(); // on cache les images
            $currentImg = $img.eq(i); // on définit la nouvelle image
            // $currentImg.css('display', 'flex'); // puis on l'affiche
            $currentImg.slideUp().fadeIn(600);
            console.log("test next");
        }
        else{
            i = indexImg;
        }

    });

    $('.prev-char').click(function(){ // image précédente

        i--; // on décrémente le compteur, puis on réalise la même chose que pour la fonction "suivante"

        if( i >= 0 ){
            // $img.css('display', 'none');
            $img.hide();
            $currentImg = $img.eq(i);
            // $currentImg.css('display', 'flex');
            $currentImg.slideUp().fadeIn(600);
            console.log("test prev")
        }
        else{
            i = 0;
        }

    });

});