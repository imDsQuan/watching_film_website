import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AllMovieComponent } from './all-movie.component';

describe('AllMovieComponent', () => {
  let component: AllMovieComponent;
  let fixture: ComponentFixture<AllMovieComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AllMovieComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(AllMovieComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
