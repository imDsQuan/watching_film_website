import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Poster} from "../../../shared/models/poster/poster";

@Injectable({
  providedIn: 'root'
})
export class PosterService {

  baseUrl = 'http://localhost:8000/api/poster';

  constructor(
    private http: HttpClient,
  ) { }

  getFeature(){
    return this.http.get<Poster>(`${this.baseUrl}/random`);
  }

  getNewRelease() {
    return this.http.get<Poster[]>(`${this.baseUrl}/getNewRelease`);
  }

  getByGenre(genre: String) {
    return this.http.get<Poster[]>(`${this.baseUrl}/genre/${genre}`);
  }
}
