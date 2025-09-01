import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { UserComponent } from './componets/user/user.component';
import { RegisterComponent } from './componets/register/register.component';
import { tokenInterceptor } from './interceptor/token.interceptor';
import { HttpClientModule, provideHttpClient, withInterceptors } from '@angular/common/http';
import { RouterOutlet } from '@angular/router';
import { AdminDashboardComponent } from './componets/admin-dashboard/admin-dashboard.component';
import { EmployeDashboardComponent } from './employe/employe-dashboard/employe-dashboard.component';
import { ClientDashboardComponent } from './componets/client-dashboard/client-dashboard.component';
import { CategorieComponent } from './componets/categorie/categorie.component';
import { ProduitComponent } from './componets/produit/produit.component';
import { AddCategorieComponent } from './componets/add-categorie/add-categorie.component';
import { AddProduitComponent } from './componets/add-produit/add-produit.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { UtilisateurComponent } from './componets/utilisateur/utilisateur.component';
import { AddUtilisateurComponent } from './componets/add-utilisateur/add-utilisateur.component';
import { CommandeComponent } from './client/commande/commande.component';
import { AddCommandeComponent } from './client/add-commande/add-commande.component';
import { CatalogueComponent } from './client/catalogue/catalogue.component';
import { LivraisonsComponent } from './client/livraisons/livraisons.component';
import { PromotionsComponent } from './client/promotions/promotions.component';
import { SupportComponent } from './client/support/support.component';
import { PanierComponent } from './client/panier/panier.component';


@NgModule({
  declarations: [
    AppComponent,
    UserComponent,
    RegisterComponent,
    AdminDashboardComponent,
    EmployeDashboardComponent,
    ClientDashboardComponent,
    CategorieComponent,
    ProduitComponent,
    AddCategorieComponent,
    AddProduitComponent,
    UtilisateurComponent,
    AddUtilisateurComponent,
    CommandeComponent,
    AddCommandeComponent,
    CatalogueComponent,
    LivraisonsComponent,
    PromotionsComponent,
    SupportComponent,
    PanierComponent,
    CommandeComponent,
    
 
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    ReactiveFormsModule ,
    RouterOutlet,
    FormsModule,

    
    
    
  ],
  providers: [
    provideHttpClient(
      withInterceptors([tokenInterceptor])
    )
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
