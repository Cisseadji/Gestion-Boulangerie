import { ProduitCommande } from "./produit-commande";

export class Commande {
  id!: number;
  id_client!: number;
  total!: number;
  statut!: 'EN_PREPARATION' | 'PRETE' | 'EN_LIVRAISON' | 'LIVREE';
  mode_paiement!: 'EN_LIGNE' | 'A_LA_LIVRAISON';
  date_commande!: string;

  // Ajout de la liste de produits pour éviter l'erreur
  produits!: ProduitCommande[];
  adresse!: string;
}
