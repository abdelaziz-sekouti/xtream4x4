<?php
/**
 * Contact page template
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        
        <header class="entry-header">
            <h1 class="entry-title">Contactez-nous</h1>
        </header>
        
        <div class="entry-content">
            <p class="section-description">Nous sommes à votre disposition pour toutes vos questions et besoins en réparation 4x4.</p>
            
            <div class="contact-container">
                <div class="contact-info">
                    <h3>Contactez-nous</h3>
                    <p class="address">47 Av. Yakoub El Mansour, al mansour, Tanger 90000</p>
                    <p class="phone">06 61 72 06 63</p>
                    <p class="email">info@xtremeoffroad4x4-tanger.com</p>
                    
                    <h4>Horaires d'ouverture</h4>
                    <ul class="hours-list">
                        <li>Mercredi: 10:00 - 18:00</li>
                        <li>Jeudi: 10:00 - 18:00</li>
                        <li>Vendredi: 10:00 - 18:00</li>
                        <li>Samedi: 10:00 - 16:00</li>
                        <li>Dimanche: Fermé</li>
                    </ul>
                    
                    <div class="map-container">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3319.1234567890123!2d-5.795489!3d35.760555!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0%3A0x0!2zMjQsIEF2IEF2Yt1iBBVljdW4gRWwgTWFuc291ci4gTmFtIEhvd2VsbCBUYW5nZcOg!5e0!3m2!1sen!2s!4v1234567890123!5m2!1sen!2s" 
                            width="100%" 
                            height="300" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
                
                <div class="contact-form-container">
                    <h3>Envoyez un message</h3>
                    <form id="contact-form" class="contact-form" action="#" method="POST">
                        <div class="form-group">
                            <label for="name">Votre nom</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Votre email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Votre téléphone</label>
                            <input type="tel" id="phone" name="phone">
                        </div>
                        
                        <div class="form-group">
                            <label for="subject">Sujet</label>
                            <select id="subject" name="subject" required>
                                <option value="">Choisissez un sujet</option>
                                <option value="service">Service</option>
                                <option value="devis">Devis</option>
                                <option value="urgence">Urgence</option>
                                <option value="autre">Autre</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Votre message</label>
                            <textarea id="message" name="message" rows="5" required></textarea>
                        </div>
                        
                        <button type="submit" class="submit-button">Envoyer</button>
                    </form>
                    <div class="form-message"></div>
                </div>
            </div>
        </div>
        
    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>