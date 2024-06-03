import { HttpClient, HttpClientModule } from '@angular/common/http';
import { CommonModule, JsonPipe, NgIf } from '@angular/common';
import { Component, inject } from '@angular/core';
import { RouterLink, Router} from '@angular/router';
import { GameService } from '../services/game.service';
import { UserService } from '../services/user.service';
import { SecurityService } from '../services/security.service';

@Component({
  selector: 'app-my-account',
  standalone: true,
  imports: [RouterLink],
  templateUrl: './my-account.component.html',
  styleUrls: ['../game/gamedetails/gamedetails.component.css','./my-account.component.css']
})
export class MyAccountComponent {
  profile: any;
  constructor(
    private gameService: GameService,
    private userService: UserService,
    private securityService: SecurityService,
    private router: Router,
  ) {}
  ngOnInit() {
    this.loadUserInfo();
  }
  private loadUserInfo() {
  this.securityService.getUser().subscribe({
      next: data => {
          this.profile = data;
      },
      error: error => {
          console.error('Error fetching user info:', error);
      }
  });
  }
  public isUserLoggedIn(): boolean {
    return this.userService.isUserLoggedIn();
  }

  public isUserAdmin(): boolean {
    return this.userService.isUserAdmin();
  }

}
