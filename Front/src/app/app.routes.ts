import { Routes } from '@angular/router';

import { LoginComponent } from './login/login.component';
import { RegisterComponent } from './register/register.component';
import { MyAccountComponent } from './my-account/my-account.component';
import { HomeComponent } from './home/home.component';

import { AddGameComponent } from './game/add-game/add-game.component';
import { CategoryComponent } from './game/category/category.component';
import { GamedetailsComponent } from './game/gamedetails/gamedetails.component';
import { SearchComponent } from './game/search/search.component';

import { authGuard, loggedInAuthGuard } from './services/auth.guard';

export const routes: Routes = [

    { path:'', component: HomeComponent, canActivate: [authGuard]},
    { path:'login', component: LoginComponent, canActivate: [loggedInAuthGuard] },
    { path:'register', component: RegisterComponent, canActivate: [loggedInAuthGuard]},
    { path:'my-account', component: MyAccountComponent, canActivate: [authGuard]},
    { path:'addgame', component: AddGameComponent, canActivate: [authGuard] },
    { path:'category/:platform', component: CategoryComponent, canActivate: [authGuard] },
    { path:'gamedetails/:id', component: GamedetailsComponent, canActivate: [authGuard]},
    { path:'search', component: SearchComponent, canActivate: [authGuard] },
    { path: '**', redirectTo: '' },
];
