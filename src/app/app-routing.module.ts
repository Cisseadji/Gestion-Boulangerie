import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

// Composants généraux
import { UserComponent } from './componets/user/user.component';
import { RegisterComponent } from './componets/register/register.component';

// Dashboards
import { AdminDashboardComponent } from './componets/admin-dashboard/admin-dashboard.component';
import { ClientDashboardComponent } from './componets/client-dashboard/client-dashboard.component';
import { EmployeDashboardComponent } from './employe/employe-dashboard/employe-dashboard.component';

// Composants admin
import { CategorieComponent } from './componets/categorie/categorie.component';
import { AddCategorieComponent } from './componets/add-categorie/add-categorie.component';
import { ProduitComponent } from './componets/produit/produit.component';
import { AddProduitComponent } from './componets/add-produit/add-produit.component';
import { UtilisateurComponent } from './componets/utilisateur/utilisateur.component';
import { AddUtilisateurComponent } from './componets/add-utilisateur/add-utilisateur.component';

// Composants client
import { CatalogueComponent } from './client/catalogue/catalogue.component';
import { PanierComponent } from './client/panier/panier.component';
import { CommandeComponent } from './client/commande/commande.component';
import { LivraisonsComponent } from './client/livraisons/livraisons.component';
import { PromotionsComponent } from './client/promotions/promotions.component';
import { SupportComponent } from './client/support/support.component';

const routes: Routes = [
  // Pages publiques
  { path: '', redirectTo: 'login', pathMatch: 'full' },
  { path: 'login', component: UserComponent },
  { path: 'register', component: RegisterComponent },

  // Dashboard Admin avec enfants
  { 
    path: 'admin', 
    component: AdminDashboardComponent,
    children: [
      { path: 'commande', component: CommandeComponent },
      { path: 'categories', component: CategorieComponent },
      { path: 'addCategorie', component: AddCategorieComponent },
      { path: 'updateCategorie/:id', component: AddCategorieComponent },
      { path: 'produits', component: ProduitComponent },
      { path: 'addProduit', component: AddProduitComponent },
      { path: 'updateProduit/:id', component: AddProduitComponent },
      { path: 'utilisateur', component: UtilisateurComponent },
      { path: 'addUser', component: AddUtilisateurComponent },
      { path: 'updateUser/:id', component: AddUtilisateurComponent },
      { path: 'promotions', component: PromotionsComponent },
      // Redirection par défaut vers produits
      { path: '', redirectTo: 'produits', pathMatch: 'full' }
    ]
  },

  // Dashboard Client avec enfants
  {
    path: 'client',
    component: ClientDashboardComponent,
    children: [
      { path: 'catalogue', component: CatalogueComponent },
      { path: 'panier', component: PanierComponent },
      { path: 'commande', component: CommandeComponent },
      { path: 'livraisons', component: LivraisonsComponent },
      { path: 'promotions', component: PromotionsComponent },
      { path: 'support', component: SupportComponent },
      // Redirection par défaut vers catalogue
      { path: '', redirectTo: 'catalogue', pathMatch: 'full' }
    ]
  },

  {
  path: 'employe',
  component: EmployeDashboardComponent,
  children: [
    { path: 'commande', component: CommandeComponent },
    { path: 'livraisons', component: LivraisonsComponent },
    { path: 'support', component: SupportComponent },
    { path: '', redirectTo: 'commande', pathMatch: 'full' }
  ]
},


  // Page 404
  { path: '**', redirectTo: 'login' }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
