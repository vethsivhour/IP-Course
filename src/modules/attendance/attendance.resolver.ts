import { Resolver, Mutation, Args,Query,Int } from '@nestjs/graphql';
import { Attendance } from './attendance.entity';
import { StudentService } from '../student/student.service';
import { AttendanceService } from './attendance.service';
import { MarkAttendanceInput } from './dto/create-attendance.input';

@Resolver(() => Attendance)
export class AttendanceResolver {
  constructor(
    private readonly attendanceService: AttendanceService,
    private readonly studentService: StudentService,
  ) {}

  @Mutation(() => Attendance)
  markAttendance(@Args('input') input: MarkAttendanceInput) {
    return this.attendanceService.mark(input);
  }

  @Mutation(() => Boolean)
  removeAttendance(
    @Args('session') session: string,
    @Args('student_id', { type: () => Int }) student_id: number,
  ) {
    return this.attendanceService.remove(session, student_id);
  }

  @Query(() => Int)
  countAttendanceByClass(@Args('className') className: string) {
    const students = this.studentService.findByClass(className);
    return this.attendanceService.countByClass(className, students);
  }

  @Query(() => Int)
  countAttendanceByStudent(
    @Args('student_id', { type: () => Int }) student_id: number,
  ) {
    return this.attendanceService.countByStudent(student_id);
  }
}