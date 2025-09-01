export interface ProduitPivot {
  id: number;
  nom: string;
  prix: number;
  pivot: {
    quantite: number;
    prix_unitaire: number;
  };
}

export class Commande {
  id!: number;
  id_client!: number;
  total!: number;
  statut!: 'EN_PREPARATION' | 'PRETE' | 'EN_LIVRAISON' | 'LIVREE';
  mode_paiement!: 'EN_LIGNE' | 'A_LA_LIVRAISON';
  date_commande!: string;

  // Ajout de la liste de produits pour éviter l'erreur
  produits!: ProduitPivot[];
}
