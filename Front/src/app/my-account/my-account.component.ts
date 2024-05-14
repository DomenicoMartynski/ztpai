import { HttpClient, HttpClientModule } from '@angular/common/http';
import { CommonModule, JsonPipe, NgIf } from '@angular/common';
import { Component, inject } from '@angular/core';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-my-account',
  standalone: true,
  imports: [RouterLink],
  templateUrl: './my-account.component.html',
  styleUrls: ['../game/gamedetails/gamedetails.component.css','./my-account.component.css']
})
export class MyAccountComponent {
}
