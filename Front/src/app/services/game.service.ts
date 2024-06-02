import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class GameService {
  private platformsUrl = 'http://localhost:8000/api/platforms';
  private genresUrl = 'http://localhost:8000/api/genres';
  private addGameUrl = 'http://localhost:8000/api/add_game';
  constructor(private http: HttpClient) {}

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
  addGame(game: any): Observable<any> {
    // const token = sessionStorage.getItem('token');
    // if (!token) {
    //   // Handle the case where token is not available
    //   console.error('Token not found in sessionStorage.');
    //   return throwError(() => new Error('Token not found in sessionStorage.'));
    // }

    const headers = new HttpHeaders({
      'Content-Type': 'application/ld+json',
      // 'Authorization': `Bearer ${token}`
    });

    return this.http.post<any>(`${this.addGameUrl}`, game, { headers }).pipe(
        catchError(error => {
            console.error('Error adding the game', error);
            return throwError(()=> new Error('Failed to add the game to the database.'));
        })
    );
}
}
