import {Component, ElementRef, OnInit, Renderer2, ViewChild} from '@angular/core';
import {TokenService} from "../../services/auth/token/token.service";
import {AuthService} from "../../services/auth/auth.service";
import {Router} from "@angular/router";
import {UserService} from "../../services/auth/user/user.service";
import {User} from "../../../shared/models/user/User";
import Pusher from "pusher-js";
import {NotificationService} from "../../services/noti/notification.service";
import {ApiService} from "../../services/auth/api/api.service";
import {ToastrService} from "ngx-toastr";
import {GoogleApiService} from "../../services/google-api/google-api.service";
import {FacebookApiService} from "../../services/facebook/facebook-api.service";

@Component({
  selector: 'app-layout-site',
  templateUrl: './layout-site.component.html',
  styleUrls: ['./layout-site.component.scss']
})
export class LayoutSiteComponent implements OnInit {

  @ViewChild('notiBox') notiBox: ElementRef | undefined;

  @ViewChild('spinner') spinner: ElementRef | undefined;

  @ViewChild('notiNotFound') notiNotFound: ElementRef | undefined;

  active: boolean = false;

  user: User | null | undefined;

  keyword : string = '';

  down : boolean = false;

  lstNotification : any = [];

  first_time : boolean = true;

  constructor(
    private Auth: AuthService,
    private router: Router,
    private Token: TokenService,
    private User: UserService,
    private renderer: Renderer2,
    private Noti: NotificationService,
    private Api: ApiService,
    private toastr : ToastrService,
    private GG: GoogleApiService,
    private FB: FacebookApiService,
  ) {
  }

  ngOnInit(): void {

    this.user = this.User.get();

    Pusher.logToConsole = true;

    const pusher = new Pusher('42e5cf51b6e6dd385286', {
      cluster: 'ap1'
    });

    const channel = pusher.subscribe('notify-channel'+this.user?.id);
    channel.bind('notify-event', (data: any) => {
      console.log(data);
      if(this.first_time) {
        this.toggleNoti()
      }
      this.lstNotification.unshift({'data': {'data' : data.notify}});
      this.renderer.setStyle(this.notiNotFound?.nativeElement, 'display','none');
      this.renderer.setStyle(this.notiBox?.nativeElement, 'display', 'block');
      this.renderer.setStyle(this.notiBox?.nativeElement, 'max-height', '400px');
      this.renderer.setStyle(this.notiBox?.nativeElement, 'overflow', 'auto');
      this.renderer.setStyle(this.notiBox?.nativeElement, 'opacity', '1');
      this.renderer.setStyle(this.spinner?.nativeElement, 'display','none');
      this.down = true;
    });

    const publicChannel = pusher.subscribe('public-channel');
    publicChannel.bind('public-event', (data: any) => {
      console.log(data);
      if (this.first_time) {
        this.toggleNoti();
      }
      this.lstNotification.unshift({'data': {'data' : data.notify}});
      this.renderer.setStyle(this.notiNotFound?.nativeElement, 'display','none');
      this.renderer.setStyle(this.notiBox?.nativeElement, 'display', 'block');
      this.renderer.setStyle(this.notiBox?.nativeElement, 'max-height', '400px');
      this.renderer.setStyle(this.notiBox?.nativeElement, 'overflow', 'auto');
      this.renderer.setStyle(this.notiBox?.nativeElement, 'opacity', '1');
      this.renderer.setStyle(this.spinner?.nativeElement, 'display','none');
      this.down = true;
    })

  }

  showNav() {
    this.active = !this.active
  }

  logout(event: MouseEvent) {
    event.preventDefault();
    // this.FB.facebookLogout();
    // this.Api.logout().subscribe(
    //   (data : any) => {
    //     this.toastr.success(data.message);
        this.Token.remove();
        this.Auth.changeAuthStatus(false);
        this.router.navigateByUrl('/login');
        this.User.remove();
    this.GG.googleLogout();

    // }
    // )
  }

  onSearch(event: KeyboardEvent) {
    if (event.keyCode == 13) {
      console.log(this.keyword);
      this.router.navigateByUrl('/search?keyword=' + this.keyword).then(() => {
        window.location.reload();
      });
    }
  }

  navToProfile() {
    this.router.navigateByUrl('/profile');
  }

  toggleNoti() {

    this.lstNotification = [];

    this.renderer.setStyle(this.spinner?.nativeElement, 'display','flex');
    this.renderer.setStyle(this.notiNotFound?.nativeElement, 'display','none');

    this.Noti.getUnreadNoti({'user_id': this.user?.id}).subscribe(
      data => {
        this.lstNotification = data;
        this.renderer.setStyle(this.spinner?.nativeElement, 'display','none');
        if (this.lstNotification.length == 0) this.renderer.setStyle(this.notiNotFound?.nativeElement, 'display','flex');
        this.first_time = false;
      }
    )


    if(this.down) {
      this.renderer.setStyle(this.notiBox?.nativeElement, 'opacity', '0');
      this.renderer.setStyle(this.notiBox?.nativeElement, 'display', 'none');
      this.down = false;
    } else {
      this.renderer.setStyle(this.notiBox?.nativeElement, 'display', 'block');
      this.renderer.setStyle(this.notiBox?.nativeElement, 'max-height', '400px');
      this.renderer.setStyle(this.notiBox?.nativeElement, 'overflow', 'auto');
      this.renderer.setStyle(this.notiBox?.nativeElement, 'opacity', '1');
      this.down = true;
    }
  }

  onMarkAsRead() {
    this.Noti.markAsRead({'user_id': this.user?.id}).subscribe(
      data => {
        this.Noti.getUnreadNoti({'user_id': this.user?.id}).subscribe(
          data => {
            this.lstNotification = [];
            this.renderer.setStyle(this.notiNotFound?.nativeElement, 'display','flex');
          }
        )
      }
    );
  }
}
