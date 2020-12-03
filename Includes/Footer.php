<div class="footer-container">
    <div class="footer-content">
        <div class="footer-section about">
            <h2 class="logo-text"><img src="Images\FunctionalMartialArtsLOGO.png" class=""><span class="">F</span>MA</h2>
            <p class="pt-3  mb-lg-3 mb-2">
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. 
                Maiores ab accusamus fugiat placeat rem quos mollitia neque voluptates libero. 
            </p>
            <div class="contact pb-lg-2 pb-0">
                <div class="text-to-copy"><i class="fas fa-phone" ></i>&nbsp; 06 95 00 45 15 
                    <span class="tooltiptext">Copy to clipboard</span>
                </div>
                <div class="text-to-copy"><i class="fas fa-envelope"></i>&nbsp; Loualidiae@outlook.fr 
                    <span class="tooltiptext">Copy to clipboard</span>
                </div>
            </div>
            <div class="socials">
                <a href="#/"><i class="fab fa-facebook"></i></a>
                <a href="#/"><i class="fab fa-instagram"></i></a>
                <a href="#/"><i class="fab fa-twitter"></i></a>
                <a href="#/"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
        <div class="footer-section links">
            <h2 class="pl-4">Links</h2>
            <br>
            <ul>
                <a href="#/"><li><span>Events</span></li></a>
                <a href="#/"><li><span>News</span></li></a>
                <a href="#/"><li><span>Articles</span></li></a>
                <a href="#/"><li><span>Gallery</span></li></a>
                <a href="#/"><li><span>Videos</span></li></a>
                <a href="#/"><li><span>Terms and Conditions</span></li></a>
            </ul>
        </div>
        <div class="footer-section contact-form">
            <h2>Contact us</h2>
            <br>
            <form action="#/" method="post" id="contact_form" class="position-relative">
                <small id="contact_error_state"></small>
                <input id="email_contact" type="email" name="footer-email" class="footer-text-input contact-input" placeholder="Your email adress..." required>
                <textarea id="message_contact" name="message" class="footer-text-input contact-input" placeholder="Your message..." rows="3" required></textarea>
                <button type="submit" class="btn contact-btn" >
                    <i class="fa fa-paper-plane"></i> Send
                </button>
            </form>

        </div>
    </div>
    <div class="footer-bottom">
        <span class="">&copy; Designed by Diae Louali | 3wa Academy Student.</span>
    </div>
</div>

<script>
 const contactEmail = document.querySelector('#email_contact');
 const contactTxtArea = document.querySelector('#message_contact');
 const contactErrorMsg = document.querySelector('#contact_error_state');
 const form = document.querySelector('#contact_form');

        [contactEmail, contactTxtArea].forEach(inputs => {
            inputs.addEventListener('focus', () => {
            contactErrorMsg.innerHTML = '';
        });
        });

        const fakeSubmitMessage = e =>  {
            e.preventDefault();
            if (contactEmail.value == '' || contactTxtArea.value == '') {
                if (contactErrorMsg.classList.contains('text-success')) {
                    contactErrorMsg.classList.remove('text-success');
                }
                contactErrorMsg.innerHTML = 'You need to fill in both fields.';
                contactErrorMsg.classList.add('text-danger');
            } else {
                if (contactErrorMsg.classList.contains('text-danger')) {
                    contactErrorMsg.classList.remove('text-danger');
                }
                contactErrorMsg.innerHTML ='Your message has been delivered!';
                contactErrorMsg.classList.add('text-success');
                contactEmail.value = '';
                contactTxtArea.value = '';

            }
            
        }
        form.addEventListener('submit', fakeSubmitMessage);

</script>
