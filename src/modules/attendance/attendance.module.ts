import { Module } from '@nestjs/common';
import { AttendanceResolver } from './attendance.resolver';
import { AttendanceService } from './attendance.service';
import { StudentModule } from '../student/student.module'; 

@Module({
  imports: [StudentModule],
  providers: [AttendanceResolver, AttendanceService],
})
export class AttendanceModule {}