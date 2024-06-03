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
  private allGamesUrl = 'http://localhost:8000/api/games/basic/all';
  private featuredUrl = 'http://localhost:8000/api/games/basic/featured'
  private worstUrl = 'http://localhost:8000/api/games/basic/worst';
  private bestUrl = 'http://localhost:8000/api/games/basic/best';
  private addGameUrl = 'http://localhost:8000/api/add_game';
  private gameUrl = 'http://localhost:8000/api/games';
  private platformUrl = 'http://localhost:8000/api/games/platform';
  constructor(private http: HttpClient) {}

  getGame(gameId: number): Observable<any> {
    return this.http.get<any>(`${this.gameUrl}/${gameId}`).pipe(
        catchError(error => {
            console.error('Error fetching JSON data:', error);
            return throwError(()=> new Error('Something went wrong; please try again later.'));
        })
    );
}
  getGames(): Observable<any[]> {
    return this.http.get<any[]>(this.allGamesUrl).pipe(
      catchError(error => {
          console.error('Error fetching games: ', error);
          return throwError(()=> new Error('Couldnt fetch games.'));
      })
  );
  }
  getFeaturedGames(): Observable<any[]> {
    return this.http.get<any[]>(this.featuredUrl).pipe(
      catchError(error => {
          console.error('Error fetching games: ', error);
          return throwError(()=> new Error('Couldnt fetch games.'));
      })
  );
  }
  getGamesByPlatformId(platformId: number): Observable<any[]> {
    return this.http.get<any[]>(`${this.platformUrl}/${platformId}`).pipe(
      catchError(error => {
            console.error('Error fetching JSON data:', error);
            return throwError(()=> new Error('Something went wrong; please try again later.'));
      })
  );
  }


  getWorstGames(): Observable<any[]> {
    return this.http.get<any[]>(this.worstUrl).pipe(
      catchError(error => {
          console.error('Error fetching games: ', error);
          return throwError(()=> new Error('Couldnt fetch games.'));
      })
  );
  }
  getBestGames(): Observable<any[]> {
    return this.http.get<any[]>(this.bestUrl).pipe(
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
