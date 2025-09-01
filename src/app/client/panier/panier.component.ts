import { Component } from '@angular/core';
import { CartService } from '../../services/carte.service';
import { CommandeService } from '../../services/commande.service';

@Component({
  selector: 'app-panier',
  templateUrl: './panier.component.html'
})
export class PanierComponent {
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

    this.commandeService.addCommandeFromCart(items, 'A_LA_LIVRAISON').subscribe({
      next: (res) => {
        alert("✅ Commande enregistrée !");
        this.cart.clear();
      },
      error: (err) => {
        console.error(err);
        alert("❌ Erreur lors de la commande");
      }
    });
  }
}
