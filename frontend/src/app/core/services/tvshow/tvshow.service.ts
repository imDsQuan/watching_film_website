import { Injectable } from '@angular/core';
import {Poster} from "../../../shared/models/poster/poster";
import {HttpClient} from "@angular/common/http";
import {Genre} from "../../../shared/models/genre/Genre";
import {Actor} from "../../../shared/models/actor/actor";
import {Season} from "../../../shared/models/season/Season";
import {Source} from "../../../shared/models/source/source";

@Injectable({
  providedIn: 'root'
})
export class TvshowService {
  baseUrl = 'http://localhost:8000/api/tvshow';

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

  getSeason(slug: string | null) {
    return this.http.get<Season[]>(`${this.baseUrl}/${slug}/season`);
  }

  getSource(slug: string | null, episodeId: string | null) {
    return this.http.get<Source[]>(`${this.baseUrl}/${slug}/episode/${episodeId}/source`)
  }

  search(keyword: string | null) {
    return this.http.post<Poster[]>(`${this.baseUrl}/search`, {'keyword' : keyword})
  }
}
