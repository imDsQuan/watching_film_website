import { TestBed } from '@angular/core/testing';

import { FacebookApiService } from './facebook-api.service';

describe('FacebookApiService', () => {
  let service: FacebookApiService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(FacebookApiService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
