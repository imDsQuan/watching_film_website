import {MovieResponse} from "./MovieResponse";

export interface IMovieRes {
  status: String,
  message: String,
  code: number,
  data: MovieResponse
}
