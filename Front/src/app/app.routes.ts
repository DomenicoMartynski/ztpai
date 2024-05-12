import { Routes } from '@angular/router';

import { LoginComponent } from './login/login.component';
import { RegisterComponent } from './register/register.component';
import { MyAccountComponent } from './my-account/my-account.component';
import { HomeComponent } from './home/home.component';

import { AddGameComponent } from './game/add-game/add-game.component';
import { CategoryComponent } from './game/category/category.component';
import { GamedetailsComponent } from './game/gamedetails/gamedetails.component';
import { SearchComponent } from './game/search/search.component';
export const routes: Routes = [

    { path:'', component: HomeComponent },
    { path:'login', component: LoginComponent, },
    { path:'register', component: RegisterComponent },
    { path:'my-account', component: MyAccountComponent },
    { path:'addgame', component: AddGameComponent },
    { path:'category', component: CategoryComponent },
    { path:'gamedetails', component: GamedetailsComponent },
    { path:'search', component: SearchComponent },
    { path: '**', redirectTo: '' },
];
