import { Component } from '@angular/core';
import { RouterLink } from '@angular/router';
@Component({
  selector: 'app-add-game',
  standalone: true,
  imports: [RouterLink],
  templateUrl: './add-game.component.html',
  styleUrls: ['../gamedetails/gamedetails.component.css','../../my-account/my-account.component.css','./add-game.component.css']
})
export class AddGameComponent {

}
