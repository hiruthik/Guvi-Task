const animationPath = 'female-avatar.json';
    const animation = lottie.loadAnimation({
      container: document.getElementById('lottieContainer'),
      renderer: 'svg',
      loop: true,
      autoplay: true,
      path: animationPath,
    });