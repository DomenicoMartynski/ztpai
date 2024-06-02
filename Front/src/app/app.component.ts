import { Component } from '@angular/core';
import { RouterOutlet, RouterLink, Router } from '@angular/router';

import { LoginComponent } from './login/login.component';
import { RegisterComponent } from './register/register.component';
import { MyAccountComponent } from './my-account/my-account.component';
import { HomeComponent } from './home/home.component';

import { AddGameComponent } from './game/add-game/add-game.component';
import { CategoryComponent } from './game/category/category.component';
import { GamedetailsComponent } from './game/gamedetails/gamedetails.component';
import { SearchComponent } from './game/search/search.component';
import { HeaderComponent } from './header/header.component';
import { UserService } from './services/user.service';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet,
    RouterLink,
    LoginComponent,
    RegisterComponent,
    MyAccountComponent,
    HomeComponent,
    AddGameComponent,
    CategoryComponent,
    GamedetailsComponent,
    SearchComponent,
    HeaderComponent,
  ],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {
  title = 'Gamecritic';

  constructor(
    private router: Router,
    private userService: UserService,
  ) {}


  redirectTo(page: string) {
      this.router.navigate(['/', page]);
  }

  public isUserLoggedIn(): boolean {
      return this.userService.isUserLoggedIn();
  }

  public isUserAdmin(): boolean {
      return this.userService.isUserAdmin();
  }

}
