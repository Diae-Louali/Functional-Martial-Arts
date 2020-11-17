
    
    const toggleButton = document.getElementsByClassName('toggle-button')[0];
    const navbarLinks = document.getElementsByClassName('navbar-links')[0];
    const myHeaderNavdiv = document.getElementById('HEADERNavbar');
    
    toggleButton.addEventListener('click', () => {
        toggleButton.classList.toggle('open')
        navbarLinks.classList.toggle('active')
        myHeaderNavdiv.classList.toggle('padding-border-botom')
    });
    
    // SHOW PASSWORD
        var passVis = document.getElementById('IDLoginFormPassword');
        var eyeIcon = document.getElementById('EYEICON');
    
        eyeIcon.addEventListener('click', () => {
    
            if (passVis.type === 'password') {
                passVis.type = 'text';
                eyeIcon.className = 'fa fa-eye-slash';
            } else {
                passVis.type = 'password';
                eyeIcon.className = 'fa fa-eye eye-icon-gray';
            }
        });
    
    // HIDE ERROR MSG
    
        $('body').click(function() {
            $('.error-alert').addClass('d-none');
        });
    
