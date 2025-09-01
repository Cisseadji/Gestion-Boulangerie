export interface User {
  id: number;
  nom: string;
  prenom: string;
  email: string;
  telephone: string;
  role: string;
  actif: boolean;
}

export interface TokenResponse {
  user: User;
  token_type: string;
  access_token: string;
}
