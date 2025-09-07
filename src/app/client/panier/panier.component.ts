import { Component } from '@angular/core';
import { CartService } from '../../services/carte.service';
import { CommandeService } from '../../services/commande.service';

@Component({
  selector: 'app-panier',
  templateUrl: './panier.component.html'
})
export class PanierComponent {
  adresse: string = ''; // adresse saisie par le client

  constructor(
    public cart: CartService,
    private commandeService: CommandeService
  ) {}

  commander() {
    const items = this.cart.items();
    if (!items.length) {
      alert("Votre panier est vide !");
      return;
    }

    // Vérification que l'utilisateur a saisi une adresse
    if (!this.adresse.trim()) {
      alert("Veuillez saisir votre adresse !");
      return;
    }

    // Préparer les données à envoyer au backend
    const data = {
      produits: items.map(item => ({
        id: item.produit.id,
        quantite: item.quantity
      })),
      mode_paiement: 'A_LA_LIVRAISON',
      adresse: this.adresse
    };

    // Appel au service pour créer la commande
    this.commandeService.addCommandeFromCart(items, 'A_LA_LIVRAISON', this.adresse).subscribe({
      next: (res) => {
        alert("✅ Commande enregistrée !");
        this.cart.clear();
        this.adresse = ''; // réinitialiser le champ adresse
      },
      error: (err) => {
        console.error(err);
        alert("❌ Erreur lors de la commande");
      }
    });
  }
}
