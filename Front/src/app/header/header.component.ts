import { Component } from '@angular/core';
import { RouterLink, Router } from '@angular/router';
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
) { }
  logout(): void {
    localStorage.removeItem('authToken');
    this.router.navigate(['/login']).then(() => {
        window.location.reload();
      });
  }
}
