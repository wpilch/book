window.onload = function() {
    let fadeInElements = document.getElementsByClassName("fadeIn-onLoad");
    fadeIn(fadeInElements);
};

//Fade In effect
function fadeIn(elements) {
    for (let element of Array.from(elements)) {
        element.style.opacity = 1;
    }
}

