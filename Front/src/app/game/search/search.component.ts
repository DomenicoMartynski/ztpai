import { Component } from '@angular/core';
import { RouterLink } from '@angular/router';
@Component({
  selector: 'app-search',
  standalone: true,
  imports: [RouterLink],
  templateUrl: './search.component.html',
  styleUrls: ['../gamedetails/gamedetails.component.css', '../../home/home.component.css','../category/category.component.css']
})
export class SearchComponent {

}
