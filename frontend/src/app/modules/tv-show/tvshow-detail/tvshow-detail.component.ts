import { Component, OnInit } from '@angular/core';
import {Poster} from "../../../shared/models/poster/poster";
import {Genre} from "../../../shared/models/genre/Genre";
import {Actor} from "../../../shared/models/actor/actor";
import {TvshowService} from "../../../core/services/tvshow/tvshow.service";
import {ActivatedRoute} from "@angular/router";
import {MatDialog} from "@angular/material/dialog";
import {TrailerPopUpComponent} from "../../../shared/components/trailer-pop-up/trailer-pop-up.component";
import {Season} from "../../../shared/models/season/Season";

@Component({
  selector: 'app-tvshow-detail',
  templateUrl: './tvshow-detail.component.html',
  styleUrls: ['./tvshow-detail.component.scss']
})
export class TvshowDetailComponent implements OnInit {

  slug: string | null | undefined;
  tvShow: Poster | undefined;
  lstGenres: Genre[] | undefined;
  lstCast: Actor[] | undefined;
  lstSimilar: Poster[] | undefined;
  lstSeason: Season[] | undefined;
  season: Season | undefined;
  selectedSeason: any;

  constructor(
    private tvService: TvshowService,
    private route: ActivatedRoute,
    private dialogRef: MatDialog,
  ) { }

  ngOnInit(): void {
    this.tvService.getBySlug(this.route.snapshot.paramMap.get('slug')).subscribe(
      data => {
        this.slug = this.route.snapshot.paramMap.get('slug');
        console.log(data);
        this.tvShow = data;
      }
    )

    this.tvService.getGenres(this.route.snapshot.paramMap.get('slug')).subscribe(
      data => {
        this.lstGenres = data;
      }
    )

    this.tvService.getCast(this.route.snapshot.paramMap.get('slug')).subscribe(
      data => {
        this.lstCast = data;
      }
    )

    this.tvService.getSimilar(this.route.snapshot.paramMap.get('slug')).subscribe(
      data => {
        this.lstSimilar = data;
      })

    this.tvService.getSeason(this.route.snapshot.paramMap.get('slug')).subscribe(
      data => {
        console.log(data);
        this.lstSeason = data;
        this.season = this.lstSeason[0];
      }
    )

  }

  openPopup() {
    this.dialogRef.open(TrailerPopUpComponent, {
      data: {url: this.tvShow?.trailer},
    })
  }

  onChangeSeason() {
    console.log(this.selectedSeason);
    this.lstSeason?.forEach(season => {
      if (season.id == this.selectedSeason) {
        this.season = season;
        return;
      }
    })
  }
}
