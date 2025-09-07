export class Facture {
     id!: number;
  id_commande!: number;
  date_facture!: string;
  montant_total!: number;
  client!: {       
    id: number;
    nom: string;
    email: string;
    role?: string;
  }
}
