import { Component, OnInit } from '@angular/core';
import {Poster} from "../../../shared/models/poster/poster";
import {Genre} from "../../../shared/models/genre/Genre";
import {Actor} from "../../../shared/models/actor/actor";
import {TvshowService} from "../../../core/services/tvshow/tvshow.service";
import {ActivatedRoute, Router} from "@angular/router";
import {MatDialog} from "@angular/material/dialog";
import {TrailerPopUpComponent} from "../../../shared/components/trailer-pop-up/trailer-pop-up.component";
import {Season} from "../../../shared/models/season/Season";
import {MyListService} from "../../../core/services/myList/my-list.service";
import {ToastrService} from "ngx-toastr";
import {UserService} from "../../../core/services/auth/user/user.service";
import {User} from "../../../shared/models/user/User";
import {
  PaymentWarningPopupComponent
} from "../../../shared/components/payment-warning-popup/payment-warning-popup.component";
import {Episode} from "../../../shared/models/episode/Episode";

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
  user: User | undefined;


  constructor(
    private tvService: TvshowService,
    private route: ActivatedRoute,
    private dialogRef: MatDialog,
    private User: UserService,
    private MyList: MyListService,
    private toastr: ToastrService,
    private router: Router
  ) { }

  ngOnInit(): void {
    this.user = this.User.get();

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

  addToMyList() {
    this.toastr.success('Add Movie To List Successfully.');
    let data = {
      user_id : this.user?.id,
      poster_id: this.tvShow?.id,
    }
    this.MyList.addToList(data).subscribe(
      data => this.handleResponse(data),
    )
  }

  private handleResponse(data: Object) {

  }

  watchMovie(episode: Episode) {

    let dateNow = new Date();

    let sub = this.user?.subscription;

    if(!sub) {
      this.dialogRef.open(PaymentWarningPopupComponent);
    }
    else {
      if (dateNow > new Date(sub.expired_date)) {
        this.dialogRef.open(PaymentWarningPopupComponent);
      } else {
        this.router.navigateByUrl(`/tvshow/${this.slug}/episode/${episode.id}`)
      }
    }
  }

}
