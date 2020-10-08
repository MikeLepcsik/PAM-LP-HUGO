var params = {
    container: document.getElementById('lottie'),
    renderer: 'svg',
    loop: true,
    autoplay: true,
    path: 'datav2.json'
};

var animation;

animation = lottie.loadAnimation(params);