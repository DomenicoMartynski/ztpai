import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError, map } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class GameService {
  private platformsUrl = 'http://localhost:8000/api/platforms';
  private genresUrl = 'http://localhost:8000/api/genres';
  private gamesUrl = 'http://localhost:8000/api/games/basic/all';
  private addGameUrl = 'http://localhost:8000/api/add_game';
  constructor(private http: HttpClient) {}


  getGames(): Observable<any[]> {
    return this.http.get<any[]>(this.gamesUrl).pipe(
      catchError(error => {
          console.error('Error fetching games: ', error);
          return throwError(()=> new Error('Couldnt fetch games.'));
      })
  );
  }

  getPlatforms(): Observable<any[]> {
    return this.http.get<any[]>(this.platformsUrl).pipe(
      catchError(error => {
          console.error('Error fetching platforms: ', error);
          return throwError(()=> new Error('Couldnt fetch platform data.'));
      })
  );
  }
  getGenres(): Observable<any[]> {
    return this.http.get<any[]>(this.genresUrl).pipe(
      catchError(error => {
          console.error('Error fetching genres:', error);
          return throwError(()=> new Error('Couldnt fetch genres data.'));
      })
  );;
  }
  
  addGame(formData: FormData): Observable<any> {
    // const token = sessionStorage.getItem('token');
    // if (!token) {
    //   // Handle the case where token is not available
    //   console.error('Token not found in sessionStorage.');
    //   return throwError(() => new Error('Token not found in sessionStorage.'));
    // }
    const headers = new HttpHeaders({
      // 'Authorization': `Bearer ${token}`
    });
    return this.http.post<any>(`${this.addGameUrl}`, formData, { observe: 'response' }).pipe(
      map(response => {
        if (response.status === 201) {
          return response.body;
        } else {
          throw new Error('Unexpected status code: ' + response.status);
        }
      })
    );
  }
}
