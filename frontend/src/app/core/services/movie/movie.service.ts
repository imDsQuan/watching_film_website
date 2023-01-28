import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Poster} from "../../../shared/models/poster/poster";
import {IMovieRes} from "../../../shared/models/movie/IMovieRes";
import {Genre} from "../../../shared/models/genre/Genre";
import {Actor} from "../../../shared/models/actor/actor";
import {Source} from "../../../shared/models/source/source";

@Injectable({
  providedIn: 'root'
})
export class MovieService {

  baseUrl = 'http://localhost:8000/api/movie';

  constructor(
    private http: HttpClient,
  ) { }

  getAll() {
    return this.http.get<Poster[]>(`${this.baseUrl}/all`);
  }

  getBySlug(slug: string | null | undefined) {
    return this.http.get<Poster>(`${this.baseUrl}/${slug}`);
  }

  getGenres(slug: string | null) {
    return this.http.get<Genre[]>(`${this.baseUrl}/${slug}/genres`);
  }

  getCast(slug: string | null) {
    return this.http.get<Actor[]>(`${this.baseUrl}/${slug}/cast`);
  }

  getSimilar(slug: string | null) {
    return this.http.get<Poster[]>(`${this.baseUrl}/${slug}/similar`);
  }

  getSource(slug: string | null) {
    return this.http.get<Source[]>(`${this.baseUrl}/${slug}/source`) ;
  }

  search(keyword: string | null) {
    return this.http.post<Poster[]>(`${this.baseUrl}/search`, {'keyword' : keyword})
  }
}
