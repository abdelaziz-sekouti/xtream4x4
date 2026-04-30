<?php
/**
 * Booking page template
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        
        <?php xtreme_display_hero_section(); ?>
        
        <section class="booking-section">
            <div class="container">
                <div class="section-title">
                    <h2>Réserver un Service</h2>
                    <p>Choisissez votre service et planifiez votre rendez-vous</p>
                </div>
                
                <div class="booking-form-container">
                    <form id="booking-form" class="booking-form" action="#" method="POST">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="customer_name">Nom complet</label>
                                <input type="text" id="customer_name" name="customer_name" required>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="customer_email">Email</label>
                                <input type="email" id="customer_email" name="customer_email" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="customer_phone">Téléphone</label>
                                <input type="tel" id="customer_phone" name="customer_phone" required>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="vehicle_make">Marque du véhicule</label>
                                <input type="text" id="vehicle_make" name="vehicle_make" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="vehicle_model">Modèle du véhicule</label>
                                <input type="text" id="vehicle_model" name="vehicle_model" required>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="vehicle_year">Année</label>
                                <input type="number" id="vehicle_year" name="vehicle_year" min="1900" max="2024" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="service_type">Type de service</label>
                                <select id="service_type" name="service_type" required>
                                    <option value="">Choisissez un service</option>
                                    <option value="reparation-moteur">Réparation Moteur 4x4</option>
                                    <option value="entretien-complet">Entretien Complet</option>
                                    <option value="diagnostic">Diagnostic Électronique</option>
                                    <option value="installation-accessoires">Installation Accessoires</option>
                                    <option value="suspension">Suspension 4x4</option>
                                    <option value="freins">Système de Freinage</option>
                                    <option value="transmission">Transmission</option>
                                    <option value="electricite">Système Électrique</option>
                                </select>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="urgency">Urgence</label>
                                <select id="urgency" name="urgency" required>
                                    <option value="">Choisissez un niveau d'urgence</option>
                                    <option value="non-urgent">Non urgent</option>
                                    <option value="moderately-urgent">Modérément urgent</option>
                                    <option value="urgent">Urgent</option>
                                    <option value="very-urgent">Très urgent</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="preferred_date">Date souhaitée</label>
                                <input type="date" id="preferred_date" name="preferred_date" required>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="preferred_time">Heure souhaitée</label>
                                <select id="preferred_time" name="preferred_time" required>
                                    <option value="">Choisissez une heure</option>
                                    <option value="09:00">09:00</option>
                                    <option value="10:00">10:00</option>
                                    <option value="11:00">11:00</option>
                                    <option value="14:00">14:00</option>
                                    <option value="15:00">15:00</option>
                                    <option value="16:00">16:00</option>
                                    <option value="17:00">17:00</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="vehicle_problem">Problème décrit</label>
                            <textarea id="vehicle_problem" name="vehicle_problem" rows="4" placeholder="Décrivez le problème que vous rencontrez avec votre véhicule..."></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>
                                <input type="checkbox" id="terms_accepted" name="terms_accepted" required>
                                J'accepte les termes et conditions et la politique de confidentialité
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label>
                                <input type="checkbox" id="newsletter" name="newsletter">
                                Je souhaite recevoir des informations et offres par email
                            </label>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary btn-lg">Réserver maintenant</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        
    </main>
</div>

<?php get_footer(); ?>