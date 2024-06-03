import { Component } from '@angular/core';
import { RouterLink, Router } from '@angular/router';
import { UserService } from '../services/user.service';
@Component({
  selector: 'app-header',
  standalone: true,
  imports: [RouterLink],
  templateUrl: './header.component.html',
  styleUrl: './header.component.css'
})
export class HeaderComponent {
  constructor(
    private router: Router,
    private userService: UserService
) { }
  public isUserLoggedIn(): boolean {
    return this.userService.isUserLoggedIn();
  }

  public isUserAdmin(): boolean {
    return this.userService.isUserAdmin();
  }

    logout(): void {
      localStorage.removeItem('authToken');
      this.router.navigate(['/login']).then(() => {
          window.location.reload();
        });
    }
}
