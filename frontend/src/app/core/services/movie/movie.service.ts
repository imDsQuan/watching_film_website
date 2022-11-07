import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Poster} from "../../../shared/models/poster/poster";
import {IMovieRes} from "../../../shared/models/movie/IMovieRes";

@Injectable({
  providedIn: 'root'
})
export class MovieService {

  baseUrl = 'http://localhost:8000/api/movie';

  constructor(
    private http: HttpClient,
  ) { }

  getPage(page : number){
    return this.http.get<IMovieRes>(`${this.baseUrl}/getMovie?page=${page}`);
  }

  getAll() {
    return this.http.get<Poster[]>(`${this.baseUrl}/all`);
  }

  getBySlug(slug: string | null) {
    return this.http.get<Poster>(`${this.baseUrl}/${slug}`);
  }
}
