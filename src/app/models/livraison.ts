export class Livraison {
  id!: number;
  id_commande!: number;
  id_client!: number; 
  adresse!: string;
  date_livraison?: string;
  date_prevue!: string;
  statut!: 'EN_COURS' | 'LIVREE' | 'ANNULEE';
}
