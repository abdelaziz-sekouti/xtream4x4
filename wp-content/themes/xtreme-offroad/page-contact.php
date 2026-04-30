<?php get_header(); ?>

<section class="section">
    <h2>CONTACTEZ-NOUS</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 3rem;">
        <div>
            <h3 style="margin-bottom: 1.5rem;">Nos Coordonnées</h3>
            <p style="margin-bottom: 1rem;"><i class="fas fa-map-marker-alt" style="color: var(--primary); margin-right: 0.5rem;"></i>
               Zone Industrielle Sidi Ghanem, 40000 Marrakech, Maroc</p>
            <p style="margin-bottom: 1rem;"><i class="fas fa-phone" style="color: var(--primary); margin-right: 0.5rem;"></i>
               +212 (0) 661 145 645<br>
               +212 (0) 524 355 558</p>
            <p style="margin-bottom: 1rem;"><i class="fas fa-envelope" style="color: var(--primary); margin-right: 0.5rem;"></i>
               xtreme4x4@yahoo.fr</p>
            <p><i class="fas fa-clock" style="color: var(--primary); margin-right: 0.5rem;"></i>
               Lun-Ven: 8h30-18h30<br>
               Sam: 9h00-13h00</p>
        </div>
        <div>
            <h3 style="margin-bottom: 1.5rem;">Envoyez-nous un message</h3>
            <form style="display: flex; flex-direction: column; gap: 1rem;" action="#" method="POST">
                <input type="text" placeholder="Votre nom" required style="padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                <input type="email" placeholder="Votre email" required style="padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                <input type="tel" placeholder="Votre téléphone" style="padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                <textarea rows="5" placeholder="Votre message" required style="padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;"></textarea>
                <button type="submit" class="btn">Envoyer</button>
            </form>
        </div>
    </div>
</section>

<?php get_footer(); ?>
