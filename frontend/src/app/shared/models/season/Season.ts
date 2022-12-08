import {Episode} from "../episode/Episode";

export interface Season {
  id: number,
  poster_id: number,
  title?: string,
  position: number,
  episode?: Episode[],
}
