import {Poster} from "../poster/poster";

export interface MovieResponse {
  data: Poster[];
  total: number;
  page: number;
}
